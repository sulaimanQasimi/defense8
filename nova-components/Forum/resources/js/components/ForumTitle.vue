<template>
  <Card>
    <div class="title" v-text="title"/>
    </Card
  >
</template>
<script >
export default {
    props:{
        title:String
    }
}
</script>
<style scoped>
.title{
    text-align: center;
    font-size: 24px;
    padding-top: 1.6rem;
    padding-bottom: 1.6rem;

}
</style>
