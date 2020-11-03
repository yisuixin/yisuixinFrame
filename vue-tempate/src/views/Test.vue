<template>
  <v-calendar :attributes='attrs' @dayclick='dayClicked'>
          <div slot="day-popover" slot-scope="{ day, dayTitle,attributes}">
            <div class="text-xs text-gray-300 font-semibold text-center">
              {{ dayTitle }}---{{attributes}}---
              <li v-for="{key, customData} in attributes"
                                :key="key">
                          {{ customData.day }}
                        </li>
            </div>
          </div>
  </v-calendar>


<!--  <v-calendar :attributes="attributes">-->
<!--    <div-->
<!--            slot="day-popover"-->
<!--            slot-scope="{ day, dayTitle, attributes }">-->
<!--      <div class="text-xs text-gray-300 font-semibold text-center">-->
<!--        {{ dayTitle }}-->
<!--      </div>-->
<!--      <ul>-->
<!--        <li-->
<!--                v-for="{key, customData} in attributes"-->
<!--                :key="key">-->
<!--          {{ customData.description }}-->
<!--        </li>-->
<!--      </ul>-->
<!--    </div>-->
<!--  </v-calendar>-->
</template>
<style>
  #app {
    display: flex;
  }

  .selected-day {
    margin-left: 10px;
  }
</style>


<script>
  

  export default {
    data() {
      return {
        attrs: [
          {
            key: 'today',
            // 括号内传递日期可点亮指定日期，如new Date(2019, 6, 1)，也可传递多个日期：如dates: [ new Date(2018, 0, 1), new Date(2018, 0, 15) ]
            dates: new Date(),
            highlight: true,
            // popover 点亮的日期上出现提示内容
            popover: {
              label: '美好的一天！要开心呦！',
              // visibility:'hover'
            },
          },
        ]
      };
    },
    computed: {
    },
    methods: {
      dayClicked(day) {
        this.selectedDay = day;
        console.log(day);
      },
    },
  };
</script>