using System;
using System.Collections.ObjectModel;
using System.Drawing;
using System.Timers;
using System.Windows;
using System.Windows.Forms;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using Application = System.Windows.Application;
using Timer = System.Timers.Timer;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Main.xaml
    /// </summary>
    public partial class SensorsWindow : Window
    {
        public ObservableCollection<Sensor> Sensors { get; set; }
        private Timer _timer;

        public SensorsWindow()
        {
            InitializeComponent();

            // set username label
            var bc = new BrushConverter();
            usernameLabel.Content = Properties.Settings.Default.username;
            usernameLabel.Foreground = (System.Windows.Media.Brush)bc.ConvertFrom(Properties.Settings.Default.role_color);

            // set user avatar
            string avatar = Properties.Settings.Default.avatar;
            string avatarUrl = Properties.Settings.Default.apiUrl + $"asset/image?src={avatar}&type=avatar&height=30";
            user_avatar.ImageSource = new BitmapImage(new Uri(avatarUrl));

            // Initialize the timer
            _timer = new Timer(1000); // Set the interval to 1000 milliseconds (1 second)
            _timer.Elapsed += LoadSensors; // Subscribe to the Elapsed event
            _timer.AutoReset = true; // Keep the timer running
            _timer.Enabled = true; // Start the timer
        }

        private async void LoadSensors(object sender, ElapsedEventArgs e)
        {
            string messageText = null;
            var apiService = new ApiService();
            var sensors = await apiService.GetAllSensorsAsync();

            Sensors = new ObservableCollection<Sensor>();

            Application.Current.Dispatcher.Invoke(() =>
            {

                // loop through all sensors
                foreach (Sensor sensor in sensors)
                {

                    sensor.Fill = "#2ded30"; // Normalbereich (grün)

                    // Leicht zu kalt? (MinTemp + 3 bis MinTemp + 1)
                    if (sensor.CurrentTemperature <= (sensor.MinTemp + 3) && sensor.CurrentTemperature > (sensor.MinTemp + 1))
                    {
                        sensor.Fill = "#ed902d"; // Gelblich
                    }

                    // Sehr nah an zu kalt? (MinTemp + 1 bis MinTemp)
                    else if (sensor.CurrentTemperature <= (sensor.MinTemp + 1) && sensor.CurrentTemperature >= sensor.MinTemp)
                    {
                        sensor.Fill = "#ed502d"; // Orange-Gelb
                    }

                    // Zu kalt
                    else if (sensor.CurrentTemperature < sensor.MinTemp)
                    {
                        sensor.Fill = "#2d90ed"; // Blau
                        messageText = sensor.Name + " is to cold!";
                    }

                    // Leicht zu heiß? (MaxTemp - 3 bis MaxTemp - 1)
                    else if (sensor.CurrentTemperature >= (sensor.MaxTemp - 3) && sensor.CurrentTemperature < (sensor.MaxTemp - 1))
                    {
                        sensor.Fill = "#ed902d"; // Gelblich
                    }

                    // Sehr nah an zu heiß? (MaxTemp - 1 bis MaxTemp)
                    else if (sensor.CurrentTemperature >= (sensor.MaxTemp - 1) && sensor.CurrentTemperature <= sensor.MaxTemp)
                    {
                        sensor.Fill = "#ed502d"; // Orange-Gelb
                    }

                    // Zu heiß
                    else if (sensor.CurrentTemperature > sensor.MaxTemp)
                    {
                        sensor.Fill = "#ed2d2d"; // Rot
                        messageText = sensor.Name + " is to hot!";
                    }

                    if (messageText != null)
                    {
                        message.Visibility = Visibility.Visible;
                        messageContent.Content = messageText;

                        var notifyIcon = new NotifyIcon();
                        notifyIcon.Icon = new Icon("");
                        notifyIcon.Visible = true;
                        notifyIcon.ShowBalloonTip(5000, "Info", messageText, ToolTipIcon.Info);
                    }
                    else
                    {
                        message.Visibility = Visibility.Collapsed;
                    }

                    Sensors.Add(sensor);
                }

                loadingLbl.Visibility = Visibility.Hidden;
                DateTime currentTime = DateTime.Now;
                lastUpdatedLbl.Content = "Last updated: " + currentTime.ToString("HH:mm:ss") + " Uhr";
                SensorCards.ItemsSource = Sensors;
            });
        }

        private void usernameLabel_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SettingsWindow settings = new SettingsWindow();
            settings.Show();
            WindowState = WindowState.Minimized;
        }

        private void logoutBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Properties.Settings.Default.username = null;
            Properties.Settings.Default.password = null;
            Properties.Settings.Default.logged_in = false;
            Properties.Settings.Default.Save();

            Environment.Exit(0);
        }

        private void usersBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            UsersWindow users = new UsersWindow();
            users.Show();
            this.Close();
        }

        private void settingsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SettingsWindow settings = new SettingsWindow();
            settings.Show();
        }

        private void Window_Closing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            _timer.Stop();
        }

        private void logsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            LogsWindow logs = new LogsWindow();
            logs.Show();
            this.Close();
        }

        private void closeBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.Close();
        }

        private void drag_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }
    }
}
