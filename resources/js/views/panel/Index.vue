<template>
  <v-layout wrap>
    <chart-report
      color="blue"
      icon="mdi-cellphone-arrow-down"
      title="تعداد کل اپلیکیشن ها"
      type="total"
    ></chart-report>
    <chart-report color="green" icon="mdi-cellphone" title="تعداد اپلیکشن های فعال" type="enable"></chart-report>
    <chart-report
      color="red"
      icon="mdi-cellphone-erase"
      title="تعداد اپلیکشن های غیرفعال"
      type="disable"
    ></chart-report>
  </v-layout>
</template>
<script>
export default {
  
};
</script>
<style>
.v-sheet--offset {
  top: -24px;
  position: relative;
}
</style>
