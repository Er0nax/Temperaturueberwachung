using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Login.xaml
    /// </summary>
    public partial class Login : Window
    {
        public Login()
        {
            InitializeComponent();

            string username = Properties.Settings.Default.username;
            string password = Properties.Settings.Default.password;

            if (username != String.Empty && password != String.Empty)
            {
                usernameInput.Text = username ?? "Username";
                passwordInput.Password = password ?? "password";
            }
        }

        private async void loginBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {

            // get username and password
            string usernameValue = usernameInput.Text;
            string passwordValue = passwordInput.Password;

            var apiService = new ApiService();
            var result = await apiService.LoginAsync(usernameValue, passwordValue);

            // status okay?
            if (result.Status == 200)
            {
                // set token and logged in to true
                Properties.Settings.Default.logged_in = true;
                Properties.Settings.Default.user_id = result.Response.Info.Id;
                Properties.Settings.Default.username = result.Response.Info.Username;
                Properties.Settings.Default.snowflake = result.Response.Info.Snowflake;
                Properties.Settings.Default.phone = result.Response.Info.Phone ?? null;
                Properties.Settings.Default.active = result.Response.Info.Active;
                Properties.Settings.Default.last_seen = result.Response.Info.Last_Seen;
                Properties.Settings.Default.created_at = result.Response.Info.Created_At;
                Properties.Settings.Default.updated_at = result.Response.Info.Updated_At;
                Properties.Settings.Default.language = result.Response.Info.Language ?? "en";
                Properties.Settings.Default.imperial_system = result.Response.Info.Imperial_System ?? "c";
                Properties.Settings.Default.darkmode = result.Response.Info.Darkmode ?? true;
                Properties.Settings.Default.avatar = result.Response.Info.Avatar;
                Properties.Settings.Default.role_name = result.Response.Info.role_name;
                Properties.Settings.Default.role_color = result.Response.Info.role_color;
                Properties.Settings.Default.password = result.Response.Info.Password;
                Properties.Settings.Default.token = result.Response.Info.Token;

                // save settings
                Properties.Settings.Default.Save();

                // show mainwindow
                this.showMainWindow();

                return;
            }

            // set logged in to false
            Properties.Settings.Default.logged_in = false;

            // save settings
            Properties.Settings.Default.Save();

            // show error message as its just a string
            MessageBox.Show(result.Response.Message);
        }

        // Open the mainwindow and close this one
        private void showMainWindow()
        {
            SensorsWindow main = new SensorsWindow();
            main.Show();
            this.Close();
        }

        private void showRegisterBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Register register = new Register();
            register.Show();
            this.Close();
        }

        private void settingsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            SettingsWindow settings = new SettingsWindow();
            settings.Show();
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
