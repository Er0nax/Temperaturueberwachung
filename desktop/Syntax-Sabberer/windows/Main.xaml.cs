using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
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
        public ObservableCollection<Sensor> Sensors { get; set; }
        public Main()
        {
            InitializeComponent();

            // set username label
            usernameLabel.Content = Properties.Settings.Default.username;

            // set user avatar
            string avatar = Properties.Settings.Default.avatar;
            string avatarUrl = Properties.Settings.Default.apiUrl + $"asset/image?src={avatar}&type=avatar&height=30";
            user_avatar.ImageSource = new BitmapImage(new Uri(avatarUrl));

            LoadSensors();
        }

        private async void LoadSensors()
        {
            var apiService = new ApiService();
            var sensors = await apiService.GetAllSensorsAsync();

            Sensors = new ObservableCollection<Sensor>();

            foreach (Sensor sensor in sensors)
            {
                sensor.Name = "test";
                Sensors.Add(sensor);
            }

            SensorCards.ItemsSource = Sensors;
        }

        private void usernameLabel_MouseDown(object sender, MouseButtonEventArgs e)
        {
            Settings settings = new Settings();
            settings.Show();
        }
    }
}
