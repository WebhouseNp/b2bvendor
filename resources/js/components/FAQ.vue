<template>
  <frontmaster>
    <section class="faq">
      <div class="container">
        <div class="text-center heading">
          <h2>Frequently Asked Question</h2>
        </div>
        <br />
        <div class="faq-content">
          <div v-for="(faq,index) in faqs" :key="index">
            <input type="checkbox" id="question1" name="q" class="questions" />
            <div class="plus">+</div>
            <label for="question1" class="question">
              {{faq.title}}
            </label>
            <div class="answers" v-html="faq.description">
            </div>
          </div>
        </div>
      </div>
    </section>
  </frontmaster>
</template>

<script>
export default {
  name: "LoginHomePage",
  props:["faqs"],
  data(){
    return{
      faqs:[],
    }
  },
};
</script>

<style scoped>
.description p,
.list {
  margin-left: 50px;
  margin-right: 50px;
}
.list ul li {
  list-style: none;
}
.list i {
  color: #ffa500;
}
.question{
  color: #ffffffad;
  font-weight: 400;
}
</style>