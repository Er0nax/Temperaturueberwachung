using System.Text.Json.Nodes;
using System.Windows;
using System.Windows.Controls;
using Temperaturueberwachung.Helpers;
using Temperaturueberwachung.Properties;

namespace Page_Navigation_App.View
{
    /// <summary>
    /// Interaction logic for Settings.xaml
    /// </summary>
    public partial class Settings : UserControl
    {
        public Settings()
        {
            InitializeComponent();
        }

        // save settings
        private void Button_Click(object sender, System.Windows.RoutedEventArgs e)
        {

        }

        private void UserControl_Loaded(object sender, System.Windows.RoutedEventArgs e)
        {
            // set fields
            username_text.Text = config.Default.username;
            password_text.Password = config.Default.password;
        }

        private async void Button_Click(object sender, System.Windows.Input.MouseButtonEventArgs e)
        {
            // get values
            int userID = config.Default.userID;
            string username = username_text.Text;
            string password = password_text.Password;
            string token = config.Default.token;

            string url = "user/update/" + userID + "/?token=" + token;

            // username same as new one
            if(!username.Equals(config.Default.username)) {
                // add username to url
                url += "&username=" + username;
            }

            // password same as new one?
            if (!password.Equals(config.Default.password)){
                // add password to url
                url += "&password=" + password;
            }

            // send api call
            dynamic data = await ApiHelper.getResponse(url);

            // convert to json
            data = JsonObject.Parse(data);

            // get status
            var status = data["status"].ToString();

            // success?
            if (status.Equals("200"))
            {
                // update settings
                config.Default.username = username;
                config.Default.password = password;

                // save settings
                config.Default.Save();
            }

            MessageBox.Show((string)data["response"]);
        }
    }
}
