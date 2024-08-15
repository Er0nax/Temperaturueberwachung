using System.Diagnostics;
using System.Windows;
using System.Windows.Input;
using System.Windows.Media;
using Temperaturueberwachung.Controllers;
using Temperaturueberwachung.Helpers;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private bool hasUpdate = false;
        public MainWindow()
        {
            InitializeComponent();
        }

        private void closeBtn_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void minimizeBtn_Click(object sender, RoutedEventArgs e)
        {
            WindowState = WindowState.Minimized;
        }

        private void Border_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }

        private async void Window_Loaded(object sender, RoutedEventArgs e)
        {
            // check if api could be connected
            bool status = await ApiHelper.getStatusAsync();

            if (status)
            {
                api_status.ToolTip = "Connected";
                api_status.Fill = Brushes.LightGreen;
            }

            // check if update is requiered
            hasUpdate = await ApplicationController.getUpdateAsync();

            if (hasUpdate)
            {
                info_text.Text = "There is a new version available. Please update.";
                info_background.Visibility = Visibility.Visible;
            }
        }

        private void info_background_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // check if has update
            if (hasUpdate)
            {
                string url = EnvReader.GetEnv("API_URL") + "app/download";

                Process.Start(new ProcessStartInfo
                {
                    FileName = url,
                    UseShellExecute = true
                });
            }
        }

        // logout user
        private void Logout_Click(object sender, RoutedEventArgs e)
        {
            // remove userid and username
            config.Default.userID = 0;
            config.Default.username = null;

            // save settings
            config.Default.Save();

            // open login window
            Login login = new Login();
            login.Show();

            // close login window
            this.Close();
        }
    }
}
