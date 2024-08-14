using System.Windows;
using System.Windows.Controls;
using Temperaturueberwachung;
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
            // set fields
            config.Default.api_url = api_url_text.Text;

            // save settings
            config.Default.Save();

            // display message
            MessageBox.Show("Settings saved. Please restart the application.");
        }

        private void UserControl_Loaded(object sender, System.Windows.RoutedEventArgs e)
        {
            api_url_text.Text = config.Default.api_url;
            username_text.Text = config.Default.username;
        }
    }
}
