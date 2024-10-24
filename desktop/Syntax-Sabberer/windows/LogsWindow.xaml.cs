using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using System.Timers;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Effects;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using System.Windows.Threading;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Main.xaml
    /// </summary>
    public partial class LogsWindow : Window
    {
        public ObservableCollection<Log> Logs { get; set; }
        private Timer _timer;

        public LogsWindow()
        {
            InitializeComponent();

            // set username label
            var bc = new BrushConverter();
            usernameLabel.Content = Properties.Settings.Default.username;
            usernameLabel.Foreground = (Brush)bc.ConvertFrom(Properties.Settings.Default.role_color);

            // set user avatar
            string avatar = Properties.Settings.Default.avatar;
            string avatarUrl = Properties.Settings.Default.apiUrl + $"asset/image?src={avatar}&type=avatar&height=30";
            user_avatar.ImageSource = new BitmapImage(new Uri(avatarUrl));

            // Initialize the timer
            _timer = new Timer(1000); // Set the interval to 1000 milliseconds (1 second)
            _timer.Elapsed += LoadLogs; // Subscribe to the Elapsed event
            _timer.AutoReset = true; // Keep the timer running
            _timer.Enabled = true; // Start the timer
        }

        private async void LoadLogs(object sender, ElapsedEventArgs e)
        {
            var apiService = new ApiService();
            var logs = await apiService.GetAllLogsAsync();

            Logs = new ObservableCollection<Log>();

            Application.Current.Dispatcher.Invoke(() =>
            {

                // loop through all sensors
                foreach (Log log in logs)
                {
                    // custom user logic
                    log.User.Avatar = Properties.Settings.Default.apiUrl + $"asset/image?src={log.User.Avatar}&type=avatar&height=100";

                    Logs.Add(log);
                }

                loadingLbl.Visibility = Visibility.Hidden;
                DateTime currentTime = DateTime.Now;
                lastUpdatedLbl.Content = "Last updated: " + currentTime.ToString("HH:mm:ss") + " Uhr";
                LogsCards.ItemsSource = Logs;
            });
        }

        private void usernameLabel_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SettingsWindow settings = new SettingsWindow();
            settings.Show();
        }

        private void logoutBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Properties.Settings.Default.username = null;
            Properties.Settings.Default.password = null;
            Properties.Settings.Default.logged_in = false;
            Properties.Settings.Default.Save();

            Environment.Exit(0);
        }

        private void sensorsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SensorsWindow sensors = new SensorsWindow();
            sensors.Show();
            this.Close();
        }

        private void settingsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SettingsWindow settings = new SettingsWindow();
            settings.Show();
            WindowState = WindowState.Minimized;
        }

        private void Window_Closing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            _timer.Stop();
        }

        private void userBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            UsersWindow users = new UsersWindow();
            users.Show();
            this.Close();
        }

        private void closeBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.Close();
        }

        private void titleBar_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }
    }
}
