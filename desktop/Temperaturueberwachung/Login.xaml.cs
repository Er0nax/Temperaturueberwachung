using System;
using System.Text.Json.Nodes;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;
using System.Windows.Media;
using Temperaturueberwachung.Helpers;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung
{
    /// <summary>
    /// Interaktionslogik für Login.xaml
    /// </summary>
    public partial class Login : Window
    {
        private string currentView = "login";

        // constructor
        public Login()
        {
            bool envFound = EnvReader.LoadEnvToSettings(".env");

            if (!envFound)
            {
                Environment.Exit(0);
            }

            // hide window
            this.Hide();

            InitializeComponent();
        }

        // login/register btn pressed
        private async void btn_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // hide info text
            msg_background.Visibility = Visibility.Collapsed;

            // do logic
            string username = username_text.Text;
            string password = password_text.Password;
            string passwordRepeat = passwordRepeat_text.Password;

            // login window?
            if (currentView.Equals("login"))
            {
                // check login
                bool success = await this._login(username, password);

                if (success)
                {
                    // show main window
                    MainWindow mainWindow = new MainWindow();
                    mainWindow.Show();

                    // close login window
                    this.Close();
                }
            }

            // register window?
            if (currentView.Equals("register"))
            {
                // check login
                bool success = await this._register(username, password, passwordRepeat);

                if (success)
                {
                    // show main window
                    MainWindow mainWindow = new MainWindow();
                    mainWindow.Show();

                    // close login window
                    this.Close();
                }
            }
        }

        // minimize window
        private void minimizeBtn_Click(object sender, RoutedEventArgs e)
        {
            WindowState = WindowState.Minimized;
        }

        // close window
        private void closeBtn_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        // move window
        private void Border_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }

        // text under login/register btn pressed
        private void btnText_text_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // current view is login? => show register
            if (this.currentView.Equals("login"))
            {
                // update button
                btn_text.Text = "Register";
                btnText_text.Content = "Already have an account? Login here.";

                // show password reapat box
                passwordRepeat_border.Visibility = Visibility.Visible;
                passwordRepeat_text.Visibility = Visibility.Visible;

                this.currentView = "register";

                return;
            }

            // current view is register? => show login
            if (this.currentView.Equals("register"))
            {
                // update button
                btn_text.Text = "Login";
                btnText_text.Content = "No account yet? Create one here.";

                // show password reapat box
                passwordRepeat_border.Visibility = Visibility.Hidden;
                passwordRepeat_text.Visibility = Visibility.Hidden;

                this.currentView = "login";

                return;
            }
        }

        // login the user
        private async Task<bool> _login(string username, string password)
        {
            // get content
            dynamic data = await ApiHelper.getResponse("user/login/" + username + "/" + password);

            // convert to json
            data = JsonObject.Parse(data);

            // get status
            var status = data["status"].ToString();

            // success?
            if (status.Equals("200"))
            {
                // get user data
                dynamic user = data["response"]["info"];

                config.Default.userID = (int)user["id"];
                config.Default.username = (string)user["username"];
                config.Default.avatar_id = (int)user["avatar_id"];
                config.Default.role_id = (int)user["role_id"];
                config.Default.active = (bool)user["active"];
                config.Default.last_seen = (string)user["last_seen"];
                config.Default.updated_at = (string)user["updated_at"];
                config.Default.created_at = (string)user["created_at"];
                config.Default.avatar = (string)user["avatar"];
                config.Default.role_name = (string)user["role_name"];
                config.Default.role_color = (string)user["role_color"];
                config.Default.password = (string)user["password"];
                config.Default.token = (string)user["token"];

                // save settings
                config.Default.Save();

                // end function
                return true;
            }

            // display error
            msg_text.Content = data["response"];
            msg_background.Visibility = Visibility.Visible;

            return false;
        }

        // register a new user
        private async Task<bool> _register(string username, string password, string passwordRepeat)
        {
            // get content
            dynamic data = await ApiHelper.getResponse("user/register/" + username + "/" + password + "/" + passwordRepeat);

            // convert to json
            data = JsonObject.Parse(data);

            // get status
            var status = data["status"].ToString();

            // success?
            if (status.Equals("200"))
            {
                // get user data
                dynamic user = data["response"]["info"];

                config.Default.userID = (int)user["id"];
                config.Default.username = (string)user["username"];
                config.Default.avatar_id = (int)user["avatar_id"];
                config.Default.role_id = (int)user["role_id"];
                config.Default.active = (bool)user["active"];
                config.Default.last_seen = (string)user["last_seen"];
                config.Default.updated_at = (string)user["updated_at"];
                config.Default.created_at = (string)user["created_at"];
                config.Default.avatar = (string)user["avatar"];
                config.Default.role_name = (string)user["role_name"];
                config.Default.role_color = (string)user["role_color"];
                config.Default.password = (string)user["password"];
                config.Default.token = (string)user["token"];

                // save settings
                config.Default.Save();

                // end function
                return true;
            }

            // display error
            msg_text.Content = data["response"];
            msg_background.Visibility = Visibility.Visible;

            return false;
        }

        private async Task<bool> _loginByID()
        {
            // get content
            dynamic data = await ApiHelper.getResponse("user/info/" + config.Default.userID);

            // convert to json
            data = JsonObject.Parse(data);

            // get status
            var status = data["status"].ToString();

            // success?
            if (status.Equals("200"))
            {
                // get user data
                dynamic user = data["response"];

                config.Default.userID = (int)user["id"];
                config.Default.username = (string)user["username"];
                config.Default.avatar_id = (int)user["avatar_id"];
                config.Default.role_id = (int)user["role_id"];
                config.Default.active = (bool)user["active"];
                config.Default.last_seen = (string)user["last_seen"];
                config.Default.updated_at = (string)user["updated_at"];
                config.Default.created_at = (string)user["created_at"];
                config.Default.avatar = (string)user["avatar"];
                config.Default.role_name = (string)user["role_name"];
                config.Default.role_color = (string)user["role_color"];

                // save settings
                config.Default.Save();

                // end function
                return true;
            }

            return false;
        }

        // when window was initialized
        private async void Window_Initialized(object sender, EventArgs e)
        {
            // check if api could be connected
            bool status = await ApiHelper.getStatusAsync();

            if (status)
            {
                api_status.ToolTip = "Connected";
                api_status.Fill = Brushes.LightGreen;
            }
            else
            {
                // show window
                this.Show();

                MessageBox.Show("Could not connect to API. Please set a valid endpoint.");

                return;
            }

            // fetch info by userId
            bool success = await _loginByID();

            if (success)
            {
                // show main window
                MainWindow mainWindow = new MainWindow();
                mainWindow.Show();

                // close login window
                this.Close();

                return;
            }

            // show window
            this.Show();
        }

        private void username_text_GotFocus(object sender, RoutedEventArgs e)
        {
            username_text.Text = String.Empty;
        }

        private void password_text_GotFocus(object sender, RoutedEventArgs e)
        {
            password_text.Password = String.Empty;
        }

        private void passwordRepeat_text_GotFocus(object sender, RoutedEventArgs e)
        {
            passwordRepeat_text.Password = String.Empty;
        }
    }
}
