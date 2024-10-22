﻿using Newtonsoft.Json;
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
    public partial class SensorsWindow : Window
    {
        public ObservableCollection<Sensor> Sensors { get; set; }
        private Timer _timer;

        public SensorsWindow()
        {
            InitializeComponent();

            // set username label
            usernameLabel.Content = Properties.Settings.Default.username;

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
                    }
                    else
                    {
                        message.Visibility = Visibility.Collapsed;
                    }

                    Sensors.Add(sensor);
                }

                DateTime currentTime = DateTime.Now;
                lastUpdatedLbl.Content = "Last updated: " + currentTime.ToString("HH:mm:ss") + " Uhr";
                SensorCards.ItemsSource = Sensors;
            });
        }

        private void usernameLabel_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Settings settings = new Settings();
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

        private void usersBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            UsersWindow users = new UsersWindow();
            users.Show();
            this.Close();
        }

        private void settingsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Settings settings = new Settings();
            settings.Show();
        }

        private void Window_Closing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            _timer.Stop();
        }
    }
}