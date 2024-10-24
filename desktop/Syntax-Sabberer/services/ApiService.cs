using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows;

public class ApiService
{
    private readonly HttpClient _httpClient;

    public ApiService()
    {
        _httpClient = new HttpClient
        {

            BaseAddress = new Uri(Syntax_Sabberer.Properties.Settings.Default.apiUrl)
        };
    }

    public async Task<LoginResponse> LoginAsync(string username, string password)
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "username", username },
            { "password", password },
            { "token", Syntax_Sabberer.Properties.Settings.Default.token }
        });
        var response = await _httpClient.PostAsync("user/login", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<LoginResponse>(jsonResponse);
        }

        throw new Exception("Login failed.");
    }

    public async Task<RegisterResponse> RegisterAsync(string username, string password, string passwordRepeat)
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "username", username },
            { "password", password },
            { "passwordRepeat", passwordRepeat },
            { "token", Syntax_Sabberer.Properties.Settings.Default.token }
        });
        var response = await _httpClient.PostAsync("user/register", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<RegisterResponse>(jsonResponse);
        }

        throw new Exception("Registration failed.");
    }

    public async Task<List<Sensor>> GetAllSensorsAsync()
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "token", Syntax_Sabberer.Properties.Settings.Default.token }
        });
        var response = await _httpClient.PostAsync("sensor/all", content);

        if (response != null)
        {
            try
            {
                var jsonResponse = await response.Content.ReadAsStringAsync();
                var result = JsonConvert.DeserializeObject<SensorResponse>(jsonResponse);
                return result.Response;
            }
            catch (Exception e)
            {
                Clipboard.SetText(e.Message);
                // error
            }
        }

        throw new Exception("Failed to retrieve sensors.");
    }

    public async Task<List<Log>> GetAllLogsAsync()
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "token", Syntax_Sabberer.Properties.Settings.Default.token }
        });
        var response = await _httpClient.PostAsync("log/all", content);

        if (response != null)
        {
            try
            {
                var jsonResponse = await response.Content.ReadAsStringAsync();
                var result = JsonConvert.DeserializeObject<LogResponse>(jsonResponse);
                return result.Response;
            }
            catch (Exception e)
            {
                Clipboard.SetText(e.Message);
                // error
            }
        }

        throw new Exception("Failed to retrieve sensors.");
    }

    public async Task<List<User>> GetAllUsersAsync()
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "token", Syntax_Sabberer.Properties.Settings.Default.token }
        });
        var response = await _httpClient.PostAsync("user/all", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            var result = JsonConvert.DeserializeObject<UserResponse>(jsonResponse);

            return result.Response;
        }

        throw new Exception("Failed to retrieve users.");
    }

    public async Task<UserUpdateResponse> UpdateUser(Dictionary<string, string> dictionary)
    {
        var content = new FormUrlEncodedContent(dictionary);
        var response = await _httpClient.PostAsync("user/update", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<UserUpdateResponse>(jsonResponse);
        }

        throw new Exception("User update failed.");
    }
}

public class LoginResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public LoginInfo Response { get; set; }
}

public class UserUpdateResponse
{
    public int status { get; set; }
    public bool cached { get; set; }
    public UserUpdate response { get; set; }
}
public class UserUpdate
{
    public string message { get; set; }
}
public class LogResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public List<Log> Response { get; set; }
}

public class LoginInfo
{
    public string Message { get; set; }
    public UserInfo Info { get; set; }
}

public class Log
{
    public int Id { get; set; }
    public string action { get; set; }
    public string relation { get; set; }
    public int relation_id { get; set; }
    public string old_value { get; set; }
    public string new_value { get; set; }
    public string column_name { get; set; }
    public bool active { get; set; }
    public DateTime created_at { get; set; }
    public DateTime updated_at { get; set; }
    public UserInfo User { get; set; }
}

public class UserInfo
{
    public int Id { get; set; }
    public string Username { get; set; }
    public string Snowflake { get; set; }
    public string Phone { get; set; }
    public bool Active { get; set; }
    public DateTime Last_Seen { get; set; }
    public DateTime Created_At { get; set; }
    public DateTime Updated_At { get; set; }
    public string Language { get; set; }
    public string Imperial_System { get; set; }
    public bool? Darkmode { get; set; }
    public string Avatar { get; set; }
    public string role_name { get; set; }
    public string role_color { get; set; }
    public string Password { get; set; }
    public string Token { get; set; }
}

public class RegisterResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public RegisterInfo Response { get; set; }
}

public class RegisterInfo
{
    public string Message { get; set; }
    public UserInfo Info { get; set; }
}

public class SensorResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public List<Sensor> Response { get; set; }
}

public class Sensor
{
    public int Id { get; set; }
    public double MaxTemp { get; set; }
    public double MinTemp { get; set; }
    public string Name { get; set; }
    public string Address { get; set; }
    public string Color { get; set; }
    public string Fill { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime UpdatedAt { get; set; }
    public string Manufacturer { get; set; }
    public double CurrentTemperature { get; set; }
    public List<Temperature> Temperatures { get; set; }
}

public class Temperature
{
    public int Id { get; set; }
    public double TemperatureValue { get; set; }
    public DateTime UpdatedAt { get; set; }
    public DateTime CreatedAt { get; set; }
}

public class UserResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public List<User> Response { get; set; }
}

public class User
{
    public int Id { get; set; }
    public string Username { get; set; }
    public string Snowflake { get; set; }
    public string Phone { get; set; }
    public bool Active { get; set; }
    public DateTime Last_Seen { get; set; }
    public DateTime Created_At { get; set; }
    public DateTime Updated_At { get; set; }
    public string Language { get; set; }
    public string Imperial_System { get; set; }
    public bool? Darkmode { get; set; }
    public string Avatar { get; set; }
    public string Role_Name { get; set; }
    public string Role_Color { get; set; }
}
