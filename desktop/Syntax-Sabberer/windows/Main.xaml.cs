using Newtonsoft.Json;
using Syntax_Sabberer.classes;
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
    public partial class Main : Window
    {
        public Main()
        {
            InitializeComponent();
        }

        private async void Window_Loaded(object sender, RoutedEventArgs e)
        {

            string url = "http://localhost/temperaturueberwachung/api/web/translation/translate";
            var postParameters = new Dictionary<string, string>
    {
        { "t", "Welcome back, {username}" },
        { "username", "Tim" }
    };

            string response = await ApiHelper.PostAsync(url, postParameters);

            if (response != null)
            {
               MessageBox.Show("API Response: " + response);
            }
        }
    }
}
