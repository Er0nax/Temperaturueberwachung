using Microsoft.Win32;
using System;
using System.Collections.Generic;
using System.IO;
using System.Net.Http;
using System.Windows;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;

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

            string avatar = Properties.Settings.Default.avatar;
            string avatarUrl = Properties.Settings.Default.apiUrl + $"asset/image?src={avatar}&type=avatar&height=100";
            setSettingsUserAvatar(avatarUrl);

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

        private void setSettingsUserAvatar(string src)
        {
            // set to settings image fill
            BitmapImage bitmap = new BitmapImage(new Uri(src));
            settingsUserAvatar.Fill = new ImageBrush { ImageSource = bitmap, Stretch = Stretch.UniformToFill };
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
            var apiService = new ApiService();
            var result = await apiService.UpdateUserWithImage(content);

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
                MessageBox.Show("New settings saved. Please restart the application to apply the new changes.", "Erfolg", MessageBoxButton.OK, MessageBoxImage.Information);

                Properties.Settings.Default.Save();
                Environment.Exit(0);
            } else
            {
                // show error message
                MessageBox.Show(result.response.message, "Error", MessageBoxButton.OK, MessageBoxImage.Information);
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

        private async void SelectAndUploadImage_Click(object sender, RoutedEventArgs e)
        {
            // OpenFileDialog für die Bildauswahl
            OpenFileDialog openFileDialog = new OpenFileDialog
            {
                Title = "Wählen Sie ein Bild aus",
                Filter = "Bilddateien (*.jpg;*.jpeg;*.png)|*.jpg;*.jpeg;*.png"
            };

            if (openFileDialog.ShowDialog() == true)
            {
                string selectedFilePath = openFileDialog.FileName;

                // Überprüfen der Dateigröße (2 MB = 2 * 1024 * 1024 Bytes)
                FileInfo fileInfo = new FileInfo(selectedFilePath);
                if (fileInfo.Length > 2 * 1024 * 1024)
                {
                    MessageBox.Show("Das Bild darf nicht größer als 2 MB sein.", "Fehler", MessageBoxButton.OK, MessageBoxImage.Error);
                    return;
                }

                // Erstelle ein Beispiel-Dictionary mit weiteren Daten (wenn erforderlich)
                Dictionary<string, string> data = new Dictionary<string, string>
                {
                    { "token", Properties.Settings.Default.token }
                };

                try
                {
                    // get the result
                    var apiService = new ApiService();
                    var result = await apiService.UpdateUserWithImage(data, selectedFilePath);

                    setSettingsUserAvatar(selectedFilePath);

                    Properties.Settings.Default.avatar = "avatar_" + Properties.Settings.Default.snowflake + ".png";
                    Properties.Settings.Default.Save();

                    // Erfolgsmeldung anzeigen
                    MessageBox.Show(result.response.message, "Erfolg", MessageBoxButton.OK, MessageBoxImage.Information);
                }
                catch (Exception ex)
                {
                    // Fehlerbehandlung
                    MessageBox.Show($"Fehler beim Hochladen: {ex.Message}", "Fehler", MessageBoxButton.OK, MessageBoxImage.Error);
                }
            }
        }
    }
}
