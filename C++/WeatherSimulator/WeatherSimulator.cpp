#include <iostream>
#include <vector>
#include <string>
#include <ctime>
#include <iomanip>
#include <random>
#include <thread>
#include <chrono>
#include <cmath>

using namespace std;

const string RESET = "\033[0m";
const string RED = "\033[31m";
const string GREEN = "\033[32m";
const string YELLOW = "\033[33m";
const string BLUE = "\033[34m";
const string MAGENTA = "\033[35m";
const string CYAN = "\033[36m";
const string WHITE = "\033[37m";

class WeatherData {
public:
    double temperature;
    double humidity;
    double pressure;
    double windSpeed;
    string condition;
    time_t timestamp;

    WeatherData(double temp, double hum, double pres, double wind, string cond)
        : temperature(temp), humidity(hum), pressure(pres), 
          windSpeed(wind), condition(cond), timestamp(time(nullptr)) {}
};

class WeatherSimulator {
private:
    vector<WeatherData> forecast;
    mt19937 rng;
    uniform_real_distribution<double> tempDist;
    uniform_real_distribution<double> humDist;
    uniform_real_distribution<double> presDist;
    uniform_real_distribution<double> windDist;

    const vector<string> conditions = {
        "Sunny", "Partly Cloudy", "Cloudy", 
        "Rainy", "Thunderstorm", "Snowy"
    };

    string getWeatherSymbol(const string& condition) {
        if (condition == "Sunny") return "☀️";
        if (condition == "Partly Cloudy") return "⛅";
        if (condition == "Cloudy") return "☁️";
        if (condition == "Rainy") return "🌧️";
        if (condition == "Thunderstorm") return "⛈️";
        if (condition == "Snowy") return "❄️";
        return "?";
    }

    string getTemperatureColor(double temp) {
        if (temp > 30) return RED;
        if (temp > 20) return YELLOW;
        if (temp > 10) return GREEN;
        if (temp > 0) return CYAN;
        return BLUE;
    }

    void generateForecast() {
        forecast.clear();
        time_t now = time(nullptr);
        
        for (int i = 0; i < 7; i++) {
            double baseTemp = 15.0 + sin(i * 0.5) * 10.0;
            double temp = baseTemp + tempDist(rng);
            double hum = 50.0 + humDist(rng);
            double pres = 1013.0 + presDist(rng);
            double wind = windDist(rng);
            
            int condIndex = static_cast<int>(abs(sin(i)) * (conditions.size() - 1));
            string condition = conditions[condIndex];
            
            forecast.emplace_back(temp, hum, pres, wind, condition);
        }
    }

public:
    WeatherSimulator() 
        : rng(random_device{}()),
          tempDist(-5.0, 5.0),
          humDist(-20.0, 20.0),
          presDist(-10.0, 10.0),
          windDist(0.0, 20.0) {
        generateForecast();
    }

    void update() {
        generateForecast();
    }

    void display() {

        cout << "\033[H\033[2J";
        cout.flush();

        cout << CYAN << "=== Weather Forecast ===" << RESET << "\n\n";
        
        time_t now = time(nullptr);
        struct tm* timeinfo = localtime(&now);
        
        for (size_t i = 0; i < forecast.size(); i++) {
            timeinfo->tm_mday += i;
            mktime(timeinfo);
            
            cout << setw(10) << put_time(timeinfo, "%a %d/%m") << "  "
                 << getWeatherSymbol(forecast[i].condition) << "  "
                 << getTemperatureColor(forecast[i].temperature)
                 << fixed << setprecision(1) << forecast[i].temperature << "°C" << RESET << "  "
                 << "Humidity: " << fixed << setprecision(0) << forecast[i].humidity << "%  "
                 << "Wind: " << fixed << setprecision(1) << forecast[i].windSpeed << " km/h  "
                 << forecast[i].condition << "\n";
            
            timeinfo->tm_mday -= i;
            mktime(timeinfo);
        }

        cout << "\n" << YELLOW << "Weather Tips:" << RESET << "\n";
        if (forecast[0].temperature < 0) {
            cout << "❄️ Bundle up! It's freezing outside.\n";
        } else if (forecast[0].temperature > 30) {
            cout << "🌡️ Stay hydrated! It's very hot today.\n";
        }
        
        if (forecast[0].condition == "Rainy" || forecast[0].condition == "Thunderstorm") {
            cout << "☔ Don't forget your umbrella!\n";
        }
        
        if (forecast[0].windSpeed > 15) {
            cout << "💨 Be careful, strong winds today!\n";
        }
    }
};

int main() {
    WeatherSimulator simulator;
    
    while (true) {
        simulator.update();
        simulator.display();
        this_thread::sleep_for(chrono::seconds(5));
    }
    
    return 0;
} 