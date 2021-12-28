<template>
  <div class="ibox-body" style="">
    <form>
      <div class="mb-3 bg-white rounded p-3">
        <div class="row">
          <div class="col-5">
            <h5>Select User</h5>
          </div>
        </div>
        <div>
          <div class="row">
            <div class="col-lg-6 col-sm-12 form-group">
              <label><strong>Users</strong></label>
              <select name="customer_id" id="users" class="form-control">
                <option value="">Select any one user</option>
                <option value="">asdcnsdkjn</option>
              </select>
            </div>
            <div class="col-lg-6 col-sm-12 form-group">
              <label><strong>Expiry Time</strong></label>
              <input
                class="form-control"
                type="time"
                name="expire_at"
                placeholder="Expiry Time"
              />
            </div>
          </div>
          <div class="row">
             <div class="col-5">
                 <h5>Select Product</h5>
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
                    <th>Product</th>
                    <th>Quentiry</th>
                    <th>Price</th>
                    <th>
                      <button
                        type="button"
                        class="btn btn-info"
                        @click="addNewRow"
                      >
                        <i class="fas fa-plus-circle"></i>
                        Add
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(invoice_product, k) in invoice_products" :key="k">
                    <td class="inputField">
                      <input
                        class="form-control"
                        type="text"
                        
                        v-model="invoice_product.clolor_value"
                      />
                    </td>
                    <td class="inputField">
                      <input
                        class="form-control"
                        type="text"
                       
                        v-model="invoice_product.size_value"
                      />
                    </td>
                    <td class="inputField">
                      <input
                        class="form-control"
                        type="text"
                        
                        v-model="invoice_product.price_value"
                      />
                    </td>
                    <td scope="row" class="trashIconContainer">
                      <i
                        class="far fa-trash-alt"
                        @click="deleteRow(k, invoice_product)"
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
  <!-- /.card-body -->
</template>

<script>
export default {
  data() {
    return {
      invoice_products: [
        {
          product: "",
          quentity: "",
          price: "",
        },
      ],
    };
  },
  methods: {
    deleteRow(index, invoice_product) {
      var idx = this.invoice_products.indexOf(invoice_product);
      console.log(idx, index);
      if (idx > -1) {
        this.invoice_products.splice(idx, 1);
      }
    },
    addNewRow() {
      this.invoice_products.push({
        clolor_value: "",
        size_value: "",
        sku_value: "",
        product_qty: "",
      });
    },
  },
  computed: {
    filteredCategories: function () {
      return this.options.filter((option) => {
        return option.match(this.search);
      });
    },
  },
};
</script>

<style>
.inputField {
  width: 100%;
  /* padding: 12px 20px; */
  margin: 8px 0;
  box-sizing: border-box;
}
</style>
