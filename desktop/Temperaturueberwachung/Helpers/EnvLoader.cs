using System;
using System.Collections.Specialized;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Windows;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung.Helpers
{
    public class EnvReader
    {
        // load env variables and save in settings
        public static bool LoadEnvToSettings(string envFilePath)
        {
            if (!File.Exists(envFilePath))
            {
                EnvReader.CreateEnvFile(envFilePath);
            }

            var lines = File.ReadAllLines(envFilePath);
            var envVariables = new StringCollection();

            foreach (var line in lines)
            {
                // Ignoriere leere Zeilen und Kommentare
                if (string.IsNullOrWhiteSpace(line) || line.TrimStart().StartsWith("#"))
                    continue;

                var keyValue = line.Split('=', 2);
                if (keyValue.Length == 2)
                {
                    var key = keyValue[0].Trim();
                    var value = keyValue[1].Trim();

                    // Entferne führende und abschließende Anführungszeichen
                    value = value.Trim('"');

                    envVariables.Add($"{key}={value}");
                }
            }

            // Speichere die Variablen in den Anwendungseinstellungen (Settings)
            config.Default.env = envVariables;
            config.Default.Save();

            return true;
        }

        private static void CreateEnvFile(string path)
        {
            // Define the content of the .env file
            string localIp = EnvReader.getLocalIp();
            string content = "API_URL=\"http://" + localIp + "/temperaturueberwachung/api/web/\"";

            try
            {
                // Write the content to the .env file
                File.WriteAllText(path, content);
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        // returns the local ip address
        private static string getLocalIp()
        {
            // Get all network interfaces
            var host = Dns.GetHostEntry(Dns.GetHostName());

            // Find the first IP address that is not a loopback address
            var ipAddress = host.AddressList.FirstOrDefault(ip => ip.AddressFamily == AddressFamily.InterNetwork && !IPAddress.IsLoopback(ip));

            return ipAddress?.ToString();
        }

        // read env
        public static string GetEnv(string key)
        {
            StringCollection envVariables = config.Default.env;

            if (envVariables == null)
            {
                return null;
            }

            foreach (string entry in envVariables)
            {
                var keyValue = entry.Split(new char[] { '=' }, 2);
                if (keyValue.Length == 2 && keyValue[0].Trim() == key)
                {
                    return keyValue[1].Trim();
                }
            }

            return null; // Wenn der Schlüssel nicht gefunden wird, gibt null zurück.
        }
    }

}
