using System;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung.Helpers
{
    public class ApiHelper
    {
        private static readonly HttpClient client = new HttpClient();

        // return boolean whether the api is running or not
        public static async Task<bool> getStatusAsync()
        {
            try
            {
                Uri apiUrl = new Uri(EnvReader.GetEnv("API_URL"));

                using (HttpClient client = new HttpClient())
                {
                    string result = await client.GetStringAsync(apiUrl);

                    config.Default.api_status = true;
                    return true;
                }
            }
            catch (HttpRequestException ex)
            {
                MessageBox.Show(ex.Message);
                config.Default.api_status = false;
                return false;
            }
            finally
            {
                config.Default.Save();
            }
        }

        // return the response
        public static async Task<string?> getResponse(string url)
        {
            // api status true?
            if (!config.Default.api_status)
            {
                return null;
            }

            try
            {
                Uri apiUrl = new Uri(EnvReader.GetEnv("API_URL"));
                HttpResponseMessage response = await client.GetAsync(apiUrl + url);
                response.EnsureSuccessStatusCode();
                string content = await response.Content.ReadAsStringAsync();
                return content;
            }
            catch (HttpRequestException e)
            {
                MessageBox.Show(e.Message);
                return null;
            }
        }
    }
}
