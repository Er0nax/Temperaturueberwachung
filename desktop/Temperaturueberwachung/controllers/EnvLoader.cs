using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;

namespace Temperaturueberwachung.controllers
{
    public class EnvReader
    {
        public Dictionary<string, string> content = new Dictionary<string, string>();

        public EnvReader(string filePath)
        {
            LoadEnvFile(filePath);
        }

        private void LoadEnvFile(string filePath)
        {
            if (!File.Exists(filePath))
            {
                MessageBox.Show("The .env file was not found.", filePath);
            }

            foreach (var line in File.ReadLines(filePath))
            {
                if (string.IsNullOrWhiteSpace(line) || line.StartsWith("#"))
                {
                    continue; // Überspringen von leeren Zeilen und Kommentaren
                }

                var parts = line.Split('=', 2); // Split in 2 Teile am ersten '='
                if (parts.Length == 2)
                {
                    var key = parts[0].Trim();
                    var value = parts[1].Trim().Trim('"'); // Entferne unnötige Leerzeichen und Anführungszeichen
                    content[key] = value;
                }
            }
        }
    }
}
