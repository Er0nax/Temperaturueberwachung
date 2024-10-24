using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Windows;
using System.Windows.Input;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Main.xaml
    /// </summary>
    public partial class SettingsWindow : Window
    {
        public SettingsWindow()
        {
            InitializeComponent();

            // set values
            apiUrlInput.Text = Properties.Settings.Default.apiUrl;
            usernameInput.Text = Properties.Settings.Default.username;
            passwordInput.Password = Properties.Settings.Default.password;
            snowflakeInput.Text = Properties.Settings.Default.snowflake;
            phoneInput.Text = Properties.Settings.Default.phone;

            switch (Properties.Settings.Default.imperial_system)
            {
                case "c":
                    imperialSystem.SelectedIndex = 0;
                    break;
                case "f":
                    imperialSystem.SelectedIndex = 1;
                    break;
                case "k":
                    imperialSystem.SelectedIndex = 2;
                    break;
            }
        }

        private async void btnSave_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // new api url?
            if(Properties.Settings.Default.apiUrl != apiUrlInput.Text)
            {
                // set new api url
                Properties.Settings.Default.apiUrl = apiUrlInput.Text;
                MessageBox.Show("New api url saved. Please restart the application to apply the new changes.");
            }

            // get default value
            string imperialSystemValue = Properties.Settings.Default.imperial_system;

            // send values to api
            string usernameValue = usernameInput.Text;
            string passwordValue = passwordInput.Password;
            string snowflakeValue = snowflakeInput.Text;
            string phoneValue = phoneInput.Text;
            switch (imperialSystem.SelectedIndex)
            {
                case 0:
                    imperialSystemValue = "c";
                    break;
                case 1:
                    imperialSystemValue = "f";
                    break;
                case 2:
                    imperialSystemValue = "k";
                    break;
            }

            // new api service
            var apiService = new ApiService();

            // add values to dictionary
            var content = new Dictionary<string, string>{
                { "username", usernameValue },
                { "password", passwordValue },
                { "snowflake", snowflakeValue },
                { "phone", phoneValue },
                { "imperial_system", imperialSystemValue },
                { "token", Properties.Settings.Default.token }
            };

            // get the result
            var result = await apiService.UpdateUser(content);

            // result ok?
            if(result.status == 200)
            {
                // set new values
                Properties.Settings.Default.username = usernameValue;
                Properties.Settings.Default.password = passwordValue;
                Properties.Settings.Default.snowflake= snowflakeValue;
                Properties.Settings.Default.phone = phoneValue;
                Properties.Settings.Default.imperial_system = imperialSystemValue;

                // show info
                MessageBox.Show("New settings saved. Please restart the application to apply the new changes.");

                Properties.Settings.Default.Save();
                Environment.Exit(0);
            } else
            {
                // show error message
                MessageBox.Show(result.response.message);
                Clipboard.SetText(result.response.message);
            }

            // save values
            Properties.Settings.Default.Save();
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
