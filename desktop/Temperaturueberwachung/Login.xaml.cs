using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.Json.Nodes;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using Temperaturueberwachung.controllers;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung
{
    /// <summary>
    /// Interaktionslogik für Login.xaml
    /// </summary>
    public partial class Login : Window
    {
        public Login()
        {
            InitializeComponent();
        }

        private async void btn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // do logic
            string username = username_text.Text;
            string password = password_text.Password;

            // get content
            dynamic data = await ApiController.getResponse("user/login/" + username + "/" + password);

            // convert to json
            data = JsonObject.Parse(data);

            // get status
            var status = data["status"].ToString();

            // success?
            if (status.Equals("200"))
            {
                // get user data
                var user = data["response"]["info"];

                config.Default.userID = (int)user["id"];
                config.Default.username = (string)user["username"];
                config.Default.avatar_id = (int)user["avatar_id"];
                config.Default.role_id = (int)user["role_id"];
                config.Default.active = (bool)user["active"];
                //config.Default.last_seen = (int)user["avatar_id"];
                //config.Default.updated_at = (int)user["avatar_id"];
                //config.Default.created_at = (int)user["avatar_id"];
                config.Default.avatar = (string)user["avatar"];
                config.Default.role_name = (string)user["role_name"];
                config.Default.role_color = (string)user["role_color"];

                // save settings
                config.Default.Save();

                // show main window
                MainWindow mainWindow = new MainWindow();
                mainWindow.Show();

                // close login window
                this.Close();

                // end function
                return;
            }

            // display error
            msg_text.Content = data["response"];
            msg_background.Visibility = Visibility.Visible;
        }

        private void minimizeBtn_Click(object sender, RoutedEventArgs e)
        {
            WindowState = WindowState.Minimized;
        }

        private void closeBtn_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void Border_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {

        }
    }
}
