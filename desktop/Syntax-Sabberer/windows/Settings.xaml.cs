using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Effects;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace Syntax_Sabberer.windows
{
    /// <summary>
    /// Interaktionslogik für Main.xaml
    /// </summary>
    public partial class Settings : Window
    {
        public Settings()
        {
            InitializeComponent();

            // set values
            apiUrlInput.Text = Properties.Settings.Default.apiUrl;
        }

        private void btnSave_MouseDown(object sender, MouseButtonEventArgs e)
        {
            // set new values to settings
            Properties.Settings.Default.apiUrl = apiUrlInput.Text;

            // save values
            Properties.Settings.Default.Save();

            // show info
            MessageBox.Show("New settings saved. Please restart the application to apply the new changes.");
            this.Close();
        }
    }
}
