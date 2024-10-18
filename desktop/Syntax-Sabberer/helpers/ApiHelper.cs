using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;

namespace YourNamespace
{
    public static class ApiHelper
    {
        // static http client
        private static readonly HttpClient client = new HttpClient();

        // check if the api is working. Returns true or false whether its successfull or not.
        public static async Task<bool> IsApiAvailable()
        {
            try
            {
                // build the url
                string apiUrl = Syntax_Sabberer.Properties.Settings.Default.apiUrl;

                // get the response of just fetching the api...
                HttpResponseMessage response = await client.GetAsync(apiUrl);

                // Check if the status code is in the 200 range (successful)
                if (response.IsSuccessStatusCode)
                {
                    // Get simple result from api
                    ApiResponse result = await PostDataAsync("app/check-api", new { }, true);

                    // Check the 'status' field
                    bool success = (result.status != 500);

                    // save value in settings
                    Syntax_Sabberer.Properties.Settings.Default.apiConnection = success;
                    Syntax_Sabberer.Properties.Settings.Default.Save();

                    // return true as everything is alright
                    return success;
                }

                // the server already returned an error
                return false;
            }
            catch (HttpRequestException)
            {
                // If there's an exception (network issues, DNS, etc.), return false
                return false;
            }
        }

        // returns the response of the api call as an instance of ApiResponse.
        public static async Task<ApiResponse> PostDataAsync(string endpoint, object data, bool forcePost = false)
        {
            // New ApiResponse object
            ApiResponse apiResponse = new ApiResponse();

            // Ccheck if connection is successfull
            bool apiConnection = Syntax_Sabberer.Properties.Settings.Default.apiConnection;

            // if the api connection failed ealier and its not a force try to get the data, return an instance with an error.
            if (!apiConnection && !forcePost)
            {
                // error instance
                return apiResponse.getInstance(500, false, "Could not connect to API! Please check the URL in the settings.");
            }

            try
            {
                // build the url with the endpoint
                string apiUrl = Syntax_Sabberer.Properties.Settings.Default.apiUrl + endpoint;

                // convert the 'data' object to a JSON string, then to a dictionary
                var json = JsonConvert.SerializeObject(data);
                var values = JsonConvert.DeserializeObject<Dictionary<string, string>>(json);

                // add token
                if (!values.ContainsKey("token") && !string.IsNullOrEmpty(Syntax_Sabberer.Properties.Settings.Default.token))
                {
                    values.Add("token", Syntax_Sabberer.Properties.Settings.Default.token);  // Adding token here
                }

                // build post content
                var content = new FormUrlEncodedContent(values);

                // get the response and send the data as a post
                var response = await client.PostAsync(apiUrl, content);

                // read the data (its json formatted as string)
                var result = await response.Content.ReadAsStringAsync();

                // convert the JSON response (string) into an ApiResponse instance
                ApiResponse apiResult = JsonConvert.DeserializeObject<ApiResponse>(result);

                return apiResult;
            }
            catch (HttpRequestException e)
            {
                // Return default error ApiResponse
                return apiResponse.getInstance(500, false, "Could not fetch information from the API!");
            }
        }

        // returns the data as readable string
        public static dynamic get(JObject json, dynamic key = null, dynamic _default = null)
        {
            if(key == null)
            {
                return json.ToString();
            }

            // Check if the key exists in the JObject
            if (json.TryGetValue(key, out JToken value) && value != null && value.Type != JTokenType.Null)
            {
                return value.ToString();
            }

            // If the key doesn't exist or the value is null, return the default value
            if(_default == null)
            {
                return "";
            }

            return _default.ToString();
        }
    }

    public class ApiResponse
    {
        public int status { get; set; }
        public bool cached { get; set; }
        public dynamic response { get; set; }

        // returns this with error values
        public ApiResponse getInstance(int status = 500, bool cached = false, dynamic response = null)
        {

            // set error values
            this.status = status;
            this.cached = cached;
            this.response = response;

            // return this object
            return this;
        }
    }
}
