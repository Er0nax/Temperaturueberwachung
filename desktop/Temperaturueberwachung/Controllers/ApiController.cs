using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Reflection.Metadata.Ecma335;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using Temperaturueberwachung.Properties;

namespace Temperaturueberwachung.controllers
{
    public class ApiController
    {
        private static readonly HttpClient client = new HttpClient();

        // return boolean whether the api is running or not
        public static bool getStatus()
        {
            try
            {
                string api_url = config.Default.api_url;

                System.Net.WebClient client = new System.Net.WebClient();

                string result = client.DownloadString(api_url);

                config.Default.api_status = true;
                return true;
            }
            catch (System.Net.WebException ex)
            {
                config.Default.api_status = false;
                return false;
            }
            finally
            {
                config.Default.Save();
            }
        }

        // return the response
        public static async Task<string> getResponse(string url)
        {
            // api status true?
            if (!config.Default.api_status)
            {
                return null;
            }

            try
            {
                string api_url = config.Default.api_url;
                HttpResponseMessage response = await client.GetAsync(api_url + url);
                response.EnsureSuccessStatusCode();
                string content = await response.Content.ReadAsStringAsync();
                return content;
            }
            catch (HttpRequestException e)
            {
                return null;
            }
        }
    }
}
