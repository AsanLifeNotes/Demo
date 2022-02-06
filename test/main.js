window.onload = ()=>{
    const Counter = {
        data() {
          return {
            counter: 220,
            counter2: 0,
            hate: "fuckyou"
          }
        },
        mounted() {
            setInterval(() => {
              this.counter++
            }, 1000)
          }
      }
      
      Vue.createApp(Counter).mount('#counter')
}
