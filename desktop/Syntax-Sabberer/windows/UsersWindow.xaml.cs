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

            Users = new ObservableCollection<User>();

            Application.Current.Dispatcher.Invoke(() =>
            {

                // loop through all sensors
                foreach (User user in users)
                {
                    // custom user logic
                    user.Avatar = Properties.Settings.Default.apiUrl + $"asset/image?src={user.Avatar}&type=avatar&height=100";

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

        private void sensorsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SensorsWindow sensors = new SensorsWindow();
            sensors.Show();
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
