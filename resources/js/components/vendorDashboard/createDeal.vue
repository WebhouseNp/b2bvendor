<template>
  <div class="ibox-body">
    <form @submit.prevent="submitData">
      <div class="mb-3 bg-white rounded p-3">
        <div class="row">
          <div class="col-5">
            <h5>Select User</h5>
            <hr />
          </div>
        </div>
        <div>
          <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-6 col-sm-12 form-group">
              <div class="form-group">
                <div style="position: relative">
                  <label for=""><strong>Customer</strong></label>
                  <div style="position: relative">
                    <input
                      type="text"
                      v-model="customer.name"
                      class="form-control"
                      @keyup="filterCustomers"
                      placeholder="Name or email"
                    />
                    <span
                      v-show="loadingCustomerList"
                      style="position: absolute; top: 6px; right: 10px"
                      ><i
                        class="fa fa-circle-o-notch text-muted"
                        v-bind:class="{ 'animate-spin': loadingCustomerList }"
                      ></i
                    ></span>
                  </div>

                  <div
                    v-if="customersList.length || errors.length"
                    class="p-2 bg-white"
                    style="
                      position: absolute;
                      left: 0;
                      right: 0;
                      z-index: 50;
                      border: 1px solid #bdbdbd;
                      max-height: 200px;
                      overflow-y: auto;
                    "
                  >
                    <div>
                      <p v-if="errors.length" style="text-align: center">
                        {{ errors }}
                      </p>
                      <div v-for="user in customersList" v-bind:key="user.id">
                        <div type="button" v-on:click="selectCustomer(user)">
                          <div>{{ user.name }}</div>
                          <p>{{ user.email }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
              ></date-picker>
              <div
                v-if="!$v.expire_at.required"
                class="invalid-feedback"
                style="margin-left: 20px;"
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
                    <!-- <th style="background-color: #d9e7e7">SN</th> -->
                    <th style="background-color: #d9e7e7">Product</th>
                    <th style="background-color: #b4d7d7">Quentiry</th>
                    <th style="background-color: #ed9494">Unit Price</th>
                    <th style="background-color: #ed9494">SubTotal Price</th>

                    <th style="background-color: #ff0000ab;">
                     Delete
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(invoice_product, index) in $v.invoice_products.$each
                      .$iter"
                    :key="index"
                  >
                    <td class="inputProduct">
                      <multiselect
                        class="form-control form"
                        @change="onChange(invoice_product.product_id.$model)"
                        v-model="invoice_product.product_id.$model"
                        :class="{
                          'is-invalid': validationStatus(
                            invoice_product.product_id
                          ),
                        }"
                        :options="products"
                        :option-height="104"
                        :custom-label="customLabel"
                        :show-labels="false"
                        :hide-selected="true"
                      >
                        <template slot="singleLabel" slot-scope="props"
                          ><img
                            class="option__image"
                            :src="props.option.image_url"
                          /><span class="option__desc"
                            ><span
                              class="option__title"
                              style="margin-left: 10px"
                              >{{ props.option.title }}</span
                            ></span
                          ></template
                        >
                        <template slot="option" slot-scope="props">
                          <div class="option__desc">
                            <img
                              class="option__image"
                              :src="props.option.image_url"
                            />
                            <span class="option__title">{{
                              props.option.title
                            }}</span>
                          </div>
                        </template>
                        <span slot="noResult">Oops! No data found.</span>
                      </multiselect>
                      <div
                        v-if="!invoice_product.product_id.required"
                        class="invalid-feedback text-danger"
                      >
                        Please Select Product First.
                      </div>
                    </td>
                    <td class="inputQuentiry">
                      <input
                        class="form-control"
                        type="number"
                        placeholder="Enter Quentity"
                        v-model.number="invoice_product.product_qty.$model"
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
                        Quentity field is required.
                      </div>
                    </td>
                    <td class="inputPrice">
                      <input
                        class="form-control"
                        type="number"
                        placeholder="Enter unit Price in rupees"
                        v-model.number="invoice_product.unit_price.$model"
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
                        Unit price field is required.
                      </div>
                    </td>
                    <td class="totalPrice">
                      <input
                        class="form-control"
                        type="text"
                        placeholder="Total price in rupees"
                        :value="subtotalRow[index]"
                        disabled
                      />
                    </td>
                    <td
                      scope="row"
                      class="trashIconContainer"
                      style="color: red"
                      @click="deleteRow(index, invoice_product.$model)"
                    >
                      <i
                        class="far fa-trash-alt"
                      ></i>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total</strong>: Rs {{ total }}</td>
                  </tr>
                  <tr>
                     <td> <button
                        type="button"
                        class="btn btn-info addProduct"
                        @click="addNewRow"
                      >
                        <i class="fas fa-plus-circle"></i>
                        Add
                      </button></td>
                   
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 mx-0 mb-3 bg-white rounded p-3">
        <button type="submit" class="btn btn-primary">
          Submit
          <span class="crateDealLoader" v-show="loadingCreateDeal"
            ><i
              class="fa fa-circle-o-notch"
              v-bind:class="{ 'animate-spin': loadingCreateDeal }"
            ></i
          ></span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import swal from "sweetalert";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import axios from "axios";
import Multiselect from "vue-multiselect";
export default {
  props: ["auth", "products"],
  components: {
    DatePicker,
    Multiselect,
  },
  data() {
    return {
      loadingCreateDeal: false,
      //select search product state
      productArray: [],
      invoice_products: [
        {
          product_id: "",
          product_qty: '',
          unit_price: '',
        },
      ],

      expire_at: "",
      customer: {
        id: "",
        name: "",
        email: "",
      },

      //search states
      customersList: [],
      loadingCustomerList: false,
      errors: "",
    };
  },
  computed: {

    //calculate sub total in each raw ============================//

    subtotalRow() {
      return this.invoice_products.map((item) => {
        return Number(item.product_qty * item.unit_price);
      });
    },

    //Calculate Total of all raws =====================//

    total() {
      return this.invoice_products.reduce((total, item) => {
        return total + item.product_qty * item.unit_price;
      }, 0);
    },
    //select search filter product ==========================================//
    //   vendorProducts() {
    //     const query = this.searchProducts.toLowerCase();
    //     if (this.searchProducts === "") {
    //       return this.productArray;
    //     }
    //     return this.productArray.filter((product) => {
    //       return Object.values(product).some((word) =>
    //         String(word).toLowerCase().includes(query)
    //       );
    //     });
    //   },
  },
  mounted() {
    // featch product from api ==========================================//
    // fetch("http://localhost:8000/api/deals/customer-search")
    //   .then((res) => res.json())
    //   .then((json) => {
    //     this.productArray = json.data;
    //   });
  },

  //validation======================================================//
  validations: {
    customer: { required },
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

    filterCustomers() {
      if (this.customer.name.length < 3) {
        return true;
      }
      this.loadingCustomerList = true;
      axios
        .get("/api/deals/customer-search?q=" + this.customer.name)
        .then((res) => {
          this.customersList = res.data.data;
          this.errors = "";
          if (this.customersList.length == 0) {
            this.errors = "No Records Found !!";
          }
          this.loadingCustomerList = false;
        });
    },

    selectCustomer(user) {
      this.customer = user;
      this.customersList = "";
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

    // select search product ===============================//

    selectProduct(index, product_id) {
      this.invoice_products[index].product_id = product_id;
      this.selectedProduct = product;
      this.isVisible = false;
    },
    customLabel({ title }) {
      return `${title}`;
    },

    // Create Deal ========================================================//
    async submitData() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      try {
        this.loadingCreateDeal = true;
        const response = await axios.post(
          "/api/deal/storeproduct",
          {
            vendor_id: this.auth,
            customer_id: this.customer.id,
            expire_at: this.expire_at,
            invoice_products: this.invoice_products,
          }
        );
        this.loadingCreateDeal = false;
        if (response.status === 200) {
          swal("Good Job!", "New deal is created!", "success");
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
@import "vue-multiselect/dist/vue-multiselect.min.css";
.ibox .ibox-body {
  margin-top: -14px;
}
select {
  padding: 0;
}
.inputProduct {
  width: 40%;
  box-sizing: border-box;
}

.inputProduct .form {
  border: none;
  margin-left: -10px;
  max-width: 386px;
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
  font-size: 13px;
}
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
/*----spiner color ----*/
.crateDealLoader {
  padding: 10px;
}
</style>
