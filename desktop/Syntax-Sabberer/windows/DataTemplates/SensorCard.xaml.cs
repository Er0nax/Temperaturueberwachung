using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;

namespace Syntax_Sabberer.windows.DataTemplates
{
    /// <summary>
    /// Interaktionslogik für SensorCard.xaml
    /// </summary>
    public partial class SensorCard : UserControl
    {
        public SensorCard()
        {
            InitializeComponent();
        }

        private void editSensorBtn_MouseDown(object sender, System.Windows.Input.MouseButtonEventArgs e)
        {
            int id = (int)sensorId.Content;

            MessageBox.Show(id.ToString());
        }
    }
}
