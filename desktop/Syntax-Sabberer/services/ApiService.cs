using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;

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
            { "password", password }
        });
        var response = await _httpClient.PostAsync("user/login", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<LoginResponse>(jsonResponse);
        }

        throw new Exception("Login failed");
    }

    public async Task<RegisterResponse> RegisterAsync(string username, string password, string passwordRepeat)
    {
        var content = new FormUrlEncodedContent(new Dictionary<string, string>{
            { "username", username },
            { "password", password },
            { "passwordRepeat", passwordRepeat }
        }); 
        var response = await _httpClient.PostAsync("user/register", content);

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<RegisterResponse>(jsonResponse);
        }

        throw new Exception("Registration failed");
    }

    public async Task<List<Sensor>> GetAllSensorsAsync()
    {
        var response = await _httpClient.GetAsync("sensor/all");

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            var result = JsonConvert.DeserializeObject<SensorResponse>(jsonResponse);
            return result.Response;
        }

        throw new Exception("Failed to retrieve sensors");
    }

    public async Task<List<User>> GetAllUsersAsync()
    {
        var response = await _httpClient.GetAsync("user");

        if (response != null)
        {
            var jsonResponse = await response.Content.ReadAsStringAsync();
            var result = JsonConvert.DeserializeObject<UserResponse>(jsonResponse);
            return result.Response;
        }

        throw new Exception("Failed to retrieve users");
    }

    // Weitere Methoden können hier hinzugefügt werden
}

public class LoginResponse
{
    public int Status { get; set; }
    public bool Cached { get; set; }
    public LoginInfo Response { get; set; }
}

public class LoginInfo
{
    public string Message { get; set; }
    public UserInfo Info { get; set; }
}

public class UserInfo
{
    public int Id { get; set; }
    public string Username { get; set; }
    public string Snowflake { get; set; }
    public string Phone { get; set; }
    public bool Active { get; set; }
    public DateTime LastSeen { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime UpdatedAt { get; set; }
    public string Language { get; set; }
    public string ImperialSystem { get; set; }
    public bool? Darkmode { get; set; }
    public string Avatar { get; set; }
    public string RoleName { get; set; }
    public string RoleColor { get; set; }
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
    public int MaxTemp { get; set; }
    public int MinTemp { get; set; }
    public string Name { get; set; }
    public string Address { get; set; }
    public string Color { get; set; }
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
    public DateTime LastSeen { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime UpdatedAt { get; set; }
    public string Language { get; set; }
    public string ImperialSystem { get; set; }
    public bool? Darkmode { get; set; }
    public string Avatar { get; set; }
    public string RoleName { get; set; }
    public string RoleColor { get; set; }
}
