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
using YourNamespace;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Login.xaml
    /// </summary>
    public partial class Register : Window
    {
        public Register()
        {
            InitializeComponent();
        }

        private async void registerBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // get username and password
            string usernameValue = usernameInput.Text;
            string passwordValue = passwordInput.Password;
            string passwordRepeatValue = passwordRepeatInput.Password;

            // creating an anonymous object and converting it to JSON
            var loginData = new
            {
                username = usernameValue,
                password = passwordValue,
                passwordRepeat = passwordRepeatValue,
            };

            // fetch the api result
            ApiResponse result = await ApiHelper.PostDataAsync("user/register", loginData);

            // status okay?
            if (result.status == 200)
            {
                // set token and logged in to true
                Properties.Settings.Default.logged_in = true;
                Properties.Settings.Default.user_id = (int)result.response.info.id.Value;
                Properties.Settings.Default.username = result.response.info.username.Value.ToString();
                Properties.Settings.Default.snowflake = result.response.info.snowflake.Value.ToString();
                Properties.Settings.Default.phone = result.response.info.phone.Value?.ToString();
                Properties.Settings.Default.active = result.response.info.active.Value;
                Properties.Settings.Default.last_seen = DateTime.Parse(result.response.info.last_seen.Value);
                Properties.Settings.Default.created_at = DateTime.Parse(result.response.info.created_at.Value);
                Properties.Settings.Default.updated_at = DateTime.Parse(result.response.info.updated_at.Value);
                Properties.Settings.Default.language = result.response.info.language.Value?.ToString() ?? "en";
                Properties.Settings.Default.imperial_system = result.response.info.imperial_system.Value?.ToString() ?? "c";
                Properties.Settings.Default.darkmode = result.response.info.darkmode.Value ?? true;
                Properties.Settings.Default.avatar = result.response.info.avatar.Value.ToString();
                Properties.Settings.Default.role_name = result.response.info.role_name.Value.ToString();
                Properties.Settings.Default.role_color = result.response.info.role_color.Value.ToString();
                Properties.Settings.Default.password = result.response.info.password.Value.ToString();
                Properties.Settings.Default.token = result.response.info.token.Value.ToString();

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
            MessageBox.Show(result.response.message.Value.ToString());
        }

        // Open the mainwindow and close this one
        private void showMainWindow()
        {
            Main main = new Main();
            main.Show();
            this.Close();
        }

        private async void Window_Loaded(object sender, RoutedEventArgs e)
        {
            // set api status
            bool apiStatus = await ApiHelper.IsApiAvailable();
        }

        // show login window
        private void showLoginBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Login login = new Login();
            login.Show();
            this.Close();
        }

        private void settingsBtn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Settings settings = new Settings();
            settings.Show();
        }
    }
}
