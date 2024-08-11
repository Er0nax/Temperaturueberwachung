using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Reflection.Metadata.Ecma335;
using System.Text;
using System.Threading.Tasks;
using System.Windows;

namespace Temperaturueberwachung.controllers
{
    public class Api
    {
        EnvReader envReader;

        private static readonly HttpClient client = new HttpClient();

        // constructor
        public Api()
        {
            this.envReader = new EnvReader(".env");
        }

        // return boolean whether the api is running or not
        public bool getStatus()
        {
            try
            {
                string api_url = this.envReader.content["API_URL"];

                System.Net.WebClient client = new System.Net.WebClient();

                string result = client.DownloadString(api_url);

                return true;
            }
            catch (System.Net.WebException ex)
            {
                return false;
            }
        }

        // return the response
        public async Task<string> getResponse(string url)
        {
            try
            {
                string api_url = this.envReader.content["API_URL"];
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
