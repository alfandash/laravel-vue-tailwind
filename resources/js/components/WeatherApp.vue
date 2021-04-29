<template>
  <div class="text-white mb-8">
    <div class="form-wrapper">
      <form v-on:submit.prevent="onFormSubmit">
        <div class="flex justify-between">
          <input
            class="w-9/12 text-gray-700 border rounded px-3 py-2 focus:outline-none leading-tight"
            type="text"
            v-model="searchText"
            v-on:keyup="onKeyUpSearch"
          >
          <button class="w-2/12 bg-gray-900 border border-gray-800 rounded" v-on:click="onFormSearch">Search</button>
        </div>
        <div class="relative">
          <ul class=" border-gray-100 w-9/12 absolute bg-white rounded rounded-t-none border" v-show="isSuggestionSearchOpen">

            <!-- <div
          v-for="(day, index) in forecasts"
          :key="day.Date"
          class="flex items-center"
          :class="{ 'mt-8' : index > 0}"
        > -->
            <li
              v-for="(suggestion, index) in locationSuggestion"
              :key="index"
              class=" w-full pl-8 pr-2 py-1 text-gray-700 border-b-2 border-gray-100 cursor-pointer"
              v-on:click="onClickSuggestion(suggestion.Key)"
            >
              {{suggestion.LocalizedName}}, {{suggestion.Country.LocalizedName}}
            </li>
          </ul>
        </div>
      </form>
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
          <img :src=currentTemprature.icon alt="current-temprature" class="h-16">
        </div>
      </div> <!-- end current weater -->

      <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
        <div
          v-for="(day, index) in forecasts"
          :key="day.Date"
          class="flex items-center"
          :class="{ 'mt-8' : index > 0}"
        >
          <div class="w-1/6 text-lg text-gray-200">
            {{ toDayOfWeek(day.Date) }}
          </div>
          <div class="w-4/6 px-4 flex items-center">
            <img :src=weatherIcon(day.Day.Icon) alt="current-temprature" class="h-full">
            <div class="ml-3">{{day.Day.IconPhrase}}</div>
          </div>
          <div class="w-1/6 text-right">
            <div>{{day.Temperature.Maximum.Value}} {{day.Temperature.Maximum.Unit}}</div>
            <div>{{day.Temperature.Minimum.Value}} {{day.Temperature.Minimum.Unit}}</div>
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
          },
          forecasts: [],
          searchText: '',
          isSuggestionSearchOpen: false,
          locationSuggestion: [],
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
              this.currentTemprature.icon = this.weatherIcon(data[0].WeatherIcon)
            })
            .finally(() => {
              fetch(`/api/weather/forecasts/daily/5day?location=${this.location.location_id}`)
                .then(response => response.json())
                .then(data => {
                  console.log(data)

                  this.forecasts = data.DailyForecasts
                })
            })

          // fetch('/api/users/1')
        },
        weatherIcon(stringIcon) {
          return '/icons/weather-icon/icon' + stringIcon + '.png';
        },
        toDayOfWeek(timestamp) {
          const newDate = new Date(timestamp)
          const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']

          return days[newDate.getDay()]
        },
        onFormSubmit: function(e) {
          // console.log(this.searchText)
        },
        onFormSearch: function(e) {
          if (this.searchText !== '') {
            this.isSuggestionSearchOpen = true;
            fetch(`/api/weather/search/location?search=${this.searchText}`)
              .then(response => response.json())
              .then(data => {
                console.log('response autocomplete',data)
                this.locationSuggestion = data
              })
          }
        },
        onKeyUpSearch: function(e) {
          // if (e.keyCode === 13) {
          //   console.log('submit')
          // }
        },
        onClickSuggestion(value) {
          console.log(value, 'value')
        }
      }
  }
</script>
