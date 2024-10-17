using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using Newtonsoft.Json;

public class ApiHelper
{
    private static readonly HttpClient _client = new HttpClient();

    /// <summary>
    /// Sendet eine POST-Anfrage an die angegebene URL mit benutzerdefinierten Parametern.
    /// </summary>
    /// <param name="url">Die URL, an die die Anfrage gesendet werden soll.</param>
    /// <param name="postParameters">Ein Dictionary mit den POST-Parametern.</param>
    /// <param name="headers">Optional: Zusätzliche Header für die Anfrage.</param>
    /// <returns>Der Inhalt der Antwort als String.</returns>
    public static async Task<string> PostAsync(string url, Dictionary<string, string> postParameters, Dictionary<string, string> headers = null)
    {
        try
        {
            // Füge optionale Header hinzu
            if (headers != null)
            {
                foreach (var header in headers)
                {
                    if (_client.DefaultRequestHeaders.Contains(header.Key))
                    {
                        _client.DefaultRequestHeaders.Remove(header.Key);
                    }
                    _client.DefaultRequestHeaders.Add(header.Key, header.Value);
                }
            }

            // Parameter in JSON umwandeln
            string jsonContent = JsonConvert.SerializeObject(postParameters);
            HttpContent content = new StringContent(jsonContent, Encoding.UTF8, "application/json");

            // POST-Anfrage senden
            HttpResponseMessage response = await _client.PostAsync(url, content);

            // Ergebnis prüfen
            if (response.IsSuccessStatusCode)
            {
                return await response.Content.ReadAsStringAsync();
            }
            else
            {
                throw new Exception($"Fehler bei der API-Anfrage: {response.StatusCode} - {response.ReasonPhrase}");
            }
        }
        catch (Exception ex)
        {
            // Fehlerbehandlung
            Console.WriteLine($"Exception: {ex.Message}");
            return null;
        }
    }
}
