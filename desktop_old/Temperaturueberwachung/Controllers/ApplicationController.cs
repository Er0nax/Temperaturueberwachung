using Newtonsoft.Json.Linq;
using System;
using System.Text.Json;
using System.Threading.Tasks;
using Temperaturueberwachung.Helpers;

namespace Temperaturueberwachung.Controllers
{
    internal class ApplicationController
    {
        private class Application
        {
            public int? id { get; set; }
            public string? name { get; set; }
            public string? version { get; set; }
            public int? downloads { get; set; }
            public bool? active { get; set; }
            public string? updated_at { get; set; }
            public string? created_at { get; set; }
        }

        public static async Task<bool> getUpdateAsync()
        {
            // get data
            var data = await ApiHelper.getResponse("app/info");

            // data empty?
            if (string.IsNullOrEmpty(data))
            {
                return false; // as we can not validate the api info
            }

            // try to convert the json data
            JObject json = JObject.Parse(data);

            // check if respone is empty
            if (String.IsNullOrEmpty(json["response"]?.ToString()))
            {
                return true;
            }

            // set response
            string response = json["response"].ToString();

            // create new application by json data
            Application? application = JsonSerializer.Deserialize<Application>(response);

            // get current version
            string currentVersion = info.version;
            string newVersion = application?.version ?? "undefined";

            // check if they differ
            if (currentVersion.Equals(newVersion))
            {
                return false;
            }

            return true;
        }
    }
}
