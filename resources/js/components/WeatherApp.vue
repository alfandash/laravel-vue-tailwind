<template>
  <div class="text-white mb-8">
    <div class="places-input">
      <input type="text" class="w-full">
    </div>
    <div class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 rounded-lg shadow-lg mt-4">
      <div class="current-weather flex items-center justify-between px-6 py-8">
        <div class="flex items-center">
          <div>
            <div class="text-6xl font-semibold">
              {{ currentTemprature.actual }} {{ currentTemprature.actualUnit}}
            </div>
            <div class="mt-2">
              feels like {{ currentTemprature.feels }} {{ currentTemprature.feelsUnit }}
            </div>
          </div>
          <div>
            <div class="mx-5">
              <div class="font-semibold">
                {{ currentTemprature.summary }}
              </div>
              <div>{{ location.name }}</div>
            </div>
          </div>
        </div>
        <div>
          icon
        </div>
      </div> <!-- end current weater -->

      <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
        <div class="flex items-center">
          <div class="w-1/6 text-lg text-gray-200">
            MON
          </div>
          <div class="w-4/6 px-4 flex items-center">
            <div>icon</div>
            <div class="ml-3"> Cloudy with a chance of showers</div>
          </div>
          <div class="w-1/6 text-right">
            <div>5C</div>
            <div>-2C</div>
          </div>
        </div>
        <div class="flex items-center mt-8">
          <div class="w-1/6 text-lg text-gray-200">
            MON
          </div>
          <div class="w-4/6 px-4 flex items-center">
            <div>icon</div>
            <div class="ml-3"> Cloudy with a chance of showers</div>
          </div>
          <div class="w-1/6 text-right">
            <div>5C</div>
            <div>-2C</div>
          </div>
        </div>
      </div> <!-- end future weather -->
    </div> <!-- end weather current -->
  </div>
</template>

<script>
    export default {
        mounted() {
            this.fetchData()
        },
        data() {
          return {
            currentTemprature: {
              actual: '',
              actualUnit: '',
              feels: '',
              feelsUnit: '',
              summary: '',
              icon: '',
            },
            location: {
              name: 'Jakarta, Indonesia',
              location_id: 208971,
            }
          }
        },
        methods: {
          fetchData() {
            fetch(`/api/weather?location=${this.location.location_id}`)
              .then(response => response.json())
              .then(data => {
                console.log(data)

                this.currentTemprature.actual = data[0].Temperature.Metric.Value;
                this.currentTemprature.actualUnit = data[0].Temperature.Metric.Unit;
                this.currentTemprature.feels = data[0].RealFeelTemperature.Metric.Value;
                this.currentTemprature.feelsUnit = data[0].RealFeelTemperature.Metric.Unit;
                this.currentTemprature.summary = data[0].WeatherText;
              })

            // fetch('/api/users/1')
          }
        }
    }
</script>
