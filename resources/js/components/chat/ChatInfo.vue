<template>
    <div v-if="show" class="information-modal border-left shadow">
      <div class="content py-4 px-5">
        <div class="text-center mb-4">
          <img src="https://www.pngitem.com/pimgs/m/146-1468479_my-profile-icon-blank-profile-picture-circle-hd.png" style="height: 200px; width: 200px; background-position: cover" />
        </div>
        <div class="text-center">
          <h4 class="h4-responsive">James Bhatta</h4>
          <div>Phone: 986570910</div>
          <div>Email: jmsbhatta@gmail.com</div>
          <div>Address: Chatakput-4, Kailai, Nepal</div>
        </div>
      </div>
      <!-- <div class="text- p-2"><button class="btn btn-primary btn-block">Close</button></div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: true,
        }
    }
}
</script>

<style scoped>
.information-modal {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(204, 204, 204, 0.4);
  /* right: 0;
  height: 100vh;
  background-color: #fff; */
}

.information-modal .content {
  background-color: #fff;
  border-radius: 4px;
}
</style>