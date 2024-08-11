using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Policy;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using Temperaturueberwachung.controllers;

namespace Temperaturueberwachung
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private Api Api;
        public MainWindow()
        {
            InitializeComponent();

            // new api class
            this.Api = new Api();

            this.setApiStatus();
        }

        // Close the window
        private void closeBtn_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        // Drage the window
        private void Border_MouseDown(object sender, MouseButtonEventArgs e)
        {
            this.DragMove();
        }

        // sets the visual status code of the api
        private void setApiStatus()
        {
            var bc = new BrushConverter();
            bool status = this.Api.getStatus();

            if (status)
            {
                api_status_green.Fill = (Brush)bc.ConvertFrom("#FF00FF17");
                api_status_red.Fill = (Brush)bc.ConvertFrom("#FF754545");

                string text = "Erfolgreich zur API verbinden.";
                api_status_text.ToolTip = text;
                api_status_green.ToolTip = text;
                api_status_red.ToolTip = text;
            }
            else
            {
                api_status_green.Fill = (Brush)bc.ConvertFrom("#FF506952");
                api_status_red.Fill = (Brush)bc.ConvertFrom("#FFFF0000");

                string text = "Es konnte keine Verbindung zur API hergestellt werden.";
                api_status_text.ToolTip = text;
                api_status_green.ToolTip = text;
                api_status_red.ToolTip = text;
            }
        }

        // Window was loaded
        private async void Window_Loaded(object sender, RoutedEventArgs e)
        {
            string content = await this.Api.getResponse("sensors/all");

            if(content != null)
            {
                // JSON formatieren
                string formattedJson = this.FormatJson(content);

                // JSON im TextBlock anzeigen
                tempText.Text = formattedJson;
            }
        }

        // convert json
        private string FormatJson(string json)
        {
            using (JsonDocument doc = JsonDocument.Parse(json))
            {
                return JsonSerializer.Serialize(doc, new JsonSerializerOptions { WriteIndented = true });
            }
        }
    }
}
