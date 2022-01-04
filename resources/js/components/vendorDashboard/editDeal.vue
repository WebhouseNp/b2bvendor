<template>
  <div class="ibox-body" style="">
    <form @submit.prevent="submitData">
      <div class="mb-3 bg-white rounded p-3">
        <div class="row">
          <div class="col-5">
            <h5>Select User{{deal.customer_id}}</h5>
            <hr />
          </div>
        </div>
        <div>
          <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-6 col-sm-12 form-group">
              <label><strong>Users</strong></label>
              <select
                class="form-control"
                v-model.trim="$v.user_id.$model"
                :class="{ 'is-invalid': validationStatus($v.user_id) }"
                v-bind:value="deal.customer_id"
              >
                <option selected value disabled>Select any one user</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.name }}
                </option>
              </select>
              <div v-if="!$v.user_id.required" class="invalid-feedback">
                Please Select User First.
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 form-group">
              <label><strong>Expiry Time</strong></label>
              <!-- <br> -->
              <date-picker
                v-model.trim="$v.expire_at.$model"
                class="form-control"
                :class="{ 'is-invalid': validationStatus($v.expire_at) }"
                lang="en"
                type="datetime"
                format=" YYYY-MM-DD [at] HH:mm a"
                style="width: 500px; border: none; margin-top: -10px"
                placeholder="select date time"
                v-bind:value="deal.customer_id"
              ></date-picker>
              <div
                v-if="!$v.expire_at.required"
                class="invalid-feedback"
                style="margin-left: 20px; margin-top: -6px"
              >
                Expiry Time is required.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-5">
              <h5>Select Product</h5>
              <hr />
            </div>
            <div class="col-lg-12 col-sm-12 form-group">
              <table>
                <thead
                  class="
                    table table-bordered table-striped
                    dataTable
                    dtr-inline
                  "
                  role="grid"
                  aria-describedby="example1_info"
                >
                  <tr>
                    <th style="background-color: #d9e7e7">Product</th>
                    <th style="background-color: #b4d7d7">Quentiry</th>
                    <th style="background-color: #ed9494">Price</th>
                    <th>
                      <button
                        type="button"
                        class="btn btn-info addProduct"
                        @click="addNewRow"
                      >
                        <i class="fas fa-plus-circle"></i>
                        Add
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(invoice_product, k) in $v.invoice_products.$each
                      .$iter"
                    :key="k"
                  >
                    <td class="inputProduct">
                      <select
                        class="form-control"
                        id="select"
                        @change="onChange(invoice_product.product_id.$model)"
                        v-model="invoice_product.product_id.$model"
                        :class="{
                          'is-invalid': validationStatus(
                            invoice_product.product_id
                          ),
                        }"
                      >
                        <option selected value disabled>Select Product</option>
                        <option
                          v-for="product in products"
                          :key="product.id"
                          :value="product.id"
                        >
                          {{ product.title }}
                        </option>
                      </select>
                      <div
                        v-if="!invoice_product.product_id.required"
                        class="invalid-feedback"
                      >
                        Please Select Product First.
                      </div>
                    </td>
                    <td class="inputQuentiry">
                      <input
                        class="form-control"
                        type="text"
                        placeholder="Enter Quentity"
                        v-model="invoice_product.product_qty.$model"
                        :class="{
                          'is-invalid': validationStatus(
                            invoice_product.product_qty
                          ),
                        }"
                        
                      />
                      <div
                        v-if="!invoice_product.product_qty.required"
                        class="invalid-feedback"
                      >
                        Product quentity field is required.
                      </div>
                    </td>
                    <td class="inputPrice">
                      <input
                        class="form-control"
                        type="text"
                        placeholder="Enter Total Price"
                        v-model="invoice_product.unit_price.$model"
                        :class="{
                          'is-invalid': validationStatus(
                            invoice_product.unit_price
                          ),
                        }"
                      />
                      <div
                        v-if="!invoice_product.unit_price.required"
                        class="invalid-feedback"
                      >
                        Price field is required.
                      </div>
                    </td>
                    <td
                      scope="row"
                      class="trashIconContainer"
                      style="color: red"
                    >
                      <i
                        class="far fa-trash-alt"
                        @click="deleteRow(k, invoice_product.$model)"
                      ></i>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 mx-0 mb-3 bg-white rounded p-3">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import swal from "sweetalert";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
  props: ["deal","users", "products"],
  components: {
    DatePicker,
  },
  data() {
    return {
      user_id: "",
      invoice_products: [
        {
          product_id: "",
          product_qty: "",
          unit_price: "",
        },
      ],
      expire_at: "",
    };
  },

  //validation======================================================//

  validations: {
    user_id: { required },
    expire_at: { required },
    invoice_products: {
      required,
      $each: {
        product_id: { required },
        product_qty: { required },
        unit_price: { required },
      },
    },
  },

  methods: {
    validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },

    // Delete populated deal entry table=======================//

    deleteRow(index, invoice_product) {
      var idx = this.invoice_products.indexOf(invoice_product);
      if (idx > -1) {
        this.invoice_products.splice(idx, 1);
      }
    },

    //Add Deal entry table ===================================//

    addNewRow() {
      this.invoice_products.push({
        product_id: "",
        product_qty: "",
        unit_price: "",
      });
    },

    // Create Deal ========================================================//

    async submitData() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/deal/storeproduct",
          {
            vendor_id: this.auth,
            customer_id: this.user_id,
            expire_at: this.expire_at,
            invoice_products: this.invoice_products,
          }
        );
        if (response.status === 200) {
          swal("Good Job!", "New deal is created!", "success");
          // window.location.href = "/account-verification";
        }
      } catch (error) {
        if (error.response.status === 422) {
          this.errors = error.response.data;
          this.validation.setMessages(this.errors.data);
        }
      }
    },
  },
};
</script>

<style scoped>
.ibox .ibox-body {
  margin-top: -14px;
}
select {
  padding: 0;
}
.inputProduct {
  width: 46%;
  padding: 10px 0px;
  /* margin: 8px 0; */
  box-sizing: border-box;
}

.inputProduct select {
  background-color: #d9e7e7;
  color: #070606;
}
.inputQuentiry input[type="text"] {
  background-color: #b4d7d7;
  color: #070606;
}
.inputPrice input[type="text"] {
  background-color: #ed9494;
  color: #070606;
}
.trashIconContainer,
.addProduct {
  cursor: pointer;
  text-align: center;
}
.table td,
.table th {
  padding: 0.75rem;
  vertical-align: middle;
  border-top: 1px solid #e9ecef;
}
.fa-regular,
.far {
  font-weight: 900;
  font-size: 20px;
}
.invalid-feedback {
  font-size: 14px;
}
</style>
