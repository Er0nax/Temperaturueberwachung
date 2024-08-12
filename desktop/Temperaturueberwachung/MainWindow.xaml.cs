using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Policy;
using System.Text;
using System.Text.Json;
using System.Threading;
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
using System.Windows.Threading;
using Temperaturueberwachung.controllers;

namespace Temperaturueberwachung
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private Api Api = new Api();
        private DispatcherTimer _timer = new DispatcherTimer();
        public MainWindow()
        {
            InitializeComponent();
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

        // set test content to field
        private async void setTempContent(object sender, EventArgs e)
        {
            string sensors = await this.Api.getResponse("sensors/all");
            sensorText.Text = this.FormatJson(sensors);

            string temperatures = await this.Api.getResponse("temperatures/latest");
            tempText.Text = this.FormatJson(temperatures);
        }

        // Window was loaded
        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            // update api info status
            setApiStatus();

            StartTimer();
        }

        // convert json
        private string FormatJson(string json)
        {
            try
            {
                using (JsonDocument doc = JsonDocument.Parse(json))
                {
                    return JsonSerializer.Serialize(doc, new JsonSerializerOptions { WriteIndented = true });
                }

            } catch(Exception ex)
            {
                return json;
            }
        }

        // timer start
        private void StartTimer()
        {
            this._timer.Interval = TimeSpan.FromSeconds(2);
            this._timer.Tick += setTempContent;
            this._timer.Start();
        }

        // window unload
        private void Window_Unloaded(object sender, RoutedEventArgs e)
        {
            // stop the timer
            this._timer.Stop();
        }
    }
}
