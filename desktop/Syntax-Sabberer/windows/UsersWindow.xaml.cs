﻿using System;
using System.Collections.ObjectModel;
using System.Timers;
using System.Windows;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Main.xaml
    /// </summary>
    public partial class UsersWindow : Window
    {
        public ObservableCollection<User> Users { get; set; }
        private Timer _timer;

        public UsersWindow()
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
            _timer.Elapsed += LoadUsers; // Subscribe to the Elapsed event
            _timer.AutoReset = true; // Keep the timer running
            _timer.Enabled = true; // Start the timer
        }

        private async void LoadUsers(object sender, ElapsedEventArgs e)
        {
            var apiService = new ApiService();
            var users = await apiService.GetAllUsersAsync();

            var bc = new BrushConverter();
            Users = new ObservableCollection<User>();

            Application.Current.Dispatcher.Invoke(() =>
            {

                // loop through all sensors
                foreach (User user in users)
                {
                    // custom user logic
                    user.Avatar = Properties.Settings.Default.apiUrl + $"asset/image?src={user.Avatar}&type=avatar&height=100";

                    if(user.Id == Properties.Settings.Default.user_id)
                    {
                        Properties.Settings.Default.username = user.Username;
                        Properties.Settings.Default.role_color = user.Role_Color;
                        Properties.Settings.Default.role_name = user.Role_Name;
                        Properties.Settings.Default.snowflake = user.Snowflake;
                        Properties.Settings.Default.Save();

                        usernameLabel.Content = user.Username;
                        usernameLabel.Foreground = (Brush)bc.ConvertFrom(user.Role_Color);
                        user_avatar.ImageSource = new BitmapImage(new Uri(user.Avatar));
                    }

                    Users.Add(user);
                }

                loadingLbl.Visibility = Visibility.Hidden;
                DateTime currentTime = DateTime.Now;
                lastUpdatedLbl.Content = "Last updated: " + currentTime.ToString("HH:mm:ss") + " Uhr";
                UserCards.ItemsSource = Users;
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
