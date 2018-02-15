<template>
    <div class="container m-t-20">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Create new offer
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.meta_description}">
                                    <label for="meta_description">Meta description:</label>
                                    <input type="text" class="form-control" id="meta_description" v-model="offer.meta_description">
                                    <small class="text-danger" v-if="errors.meta_description">{{ errors.meta_description[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_address}">
                                    <label for="company_address">Company address:</label>
                                    <input type="text" class="form-control" id="company_address" v-model="offer.company_address">
                                    <small class="text-danger" v-if="errors.company_address">{{ errors.company_address[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_customer_service_email}">
                                    <label for="company_customer_service_email">Company customer service email:</label>
                                    <input type="text" class="form-control" id="company_customer_service_email" v-model="offer.company_customer_service_email">
                                    <small class="text-danger" v-if="errors.company_customer_service_email">{{ errors.company_customer_service_email[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_customer_service_phone}">
                                    <label for="company_customer_service_phone">Company customer service phone:</label>
                                    <input type="text" class="form-control" id="company_customer_service_phone" v-model="offer.company_customer_service_phone">
                                    <small class="text-danger" v-if="errors.company_customer_service_phone">{{ errors.company_customer_service_phone[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_hours}">
                                    <label for="company_hours">Company hours:</label>
                                    <input type="text" class="form-control" id="company_hours" v-model="offer.company_hours">
                                    <small class="text-danger" v-if="errors.company_hours">{{ errors.company_hours[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_name}">
                                    <label for="company_name">Company name:</label>
                                    <input type="text" class="form-control" id="company_name" v-model="offer.company_name">
                                    <small class="text-danger" v-if="errors.company_name">{{ errors.company_name[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.company_return_address}">
                                    <label for="company_return_address">Company return address:</label>
                                    <input type="text" class="form-control" id="company_return_address" v-model="offer.company_return_address">
                                    <small class="text-danger" v-if="errors.company_return_address">{{ errors.company_return_address[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.product_name}">
                                    <label for="product_name">Product name:</label>
                                    <input type="text" class="form-control" id="product_name" v-model="offer.product_name">
                                    <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.product_rebill_price}">
                                    <label for="product_rebill_price">Product rebill price:</label>
                                    <input type="text" class="form-control" id="product_rebill_price" v-model="offer.product_rebill_price">
                                    <small class="text-danger" v-if="errors.product_rebill_price">{{ errors.product_rebill_price[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.product_rebill_days}">
                                    <label for="product_rebill_days">Product rebill days:</label>
                                    <input type="text" class="form-control" id="product_rebill_days" v-model="offer.product_rebill_days">
                                    <small class="text-danger" v-if="errors.product_rebill_days">{{ errors.product_rebill_days[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.shipping_price}">
                                    <label for="shipping_price">Shipping price:</label>
                                    <input type="text" class="form-control" id="shipping_price" v-model="offer.shipping_price">
                                    <small class="text-danger" v-if="errors.shipping_price">{{ errors.shipping_price[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o}">
                                    <input type="text" class="form-control" placeholder="o" v-model="offer.o">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e}">
                                    <input type="text" class="form-control" placeholder="e" v-model="offer.e">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o2}">
                                    <input type="text" class="form-control" placeholder="o2" v-model="offer.o2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e2}">
                                    <input type="text" class="form-control" placeholder="e2" v-model="offer.e2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o3}">
                                    <input type="text" class="form-control" placeholder="o3" v-model="offer.o3">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e3}">
                                    <input type="text" class="form-control" placeholder="e3" v-model="offer.e3">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o4}">
                                    <input type="text" class="form-control" placeholder="o4" v-model="offer.o4">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e4}">
                                    <input type="text" class="form-control" placeholder="e4" v-model="offer.e4">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o5}">
                                    <input type="text" class="form-control" placeholder="o5" v-model="offer.o5">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e5}">
                                    <input type="text" class="form-control" placeholder="e5" v-model="offer.e5">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o6}">
                                    <input type="text" class="form-control" placeholder="o6" v-model="offer.o6">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e6}">
                                    <input type="text" class="form-control" placeholder="e6" v-model="offer.e6">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o7}">
                                    <input type="text" class="form-control" placeholder="o7" v-model="offer.o7">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e7}">
                                    <input type="text" class="form-control" placeholder="e7" v-model="offer.e7">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o8}">
                                    <input type="text" class="form-control" placeholder="o8" v-model="offer.o8">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e8}">
                                    <input type="text" class="form-control" placeholder="e8" v-model="offer.e8">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.o9}">
                                    <input type="text" class="form-control" placeholder="o9" v-model="offer.o9">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  :class="{'has-error': errors.e9}">
                                    <input type="text" class="form-control" placeholder="e9" v-model="offer.e9">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.cu}">
                                    <label for="cu">Cu:</label>
                                    <input type="text" class="form-control" id="cu" v-model="offer.cu">
                                    <small class="text-danger" v-if="errors.cu">{{ errors.cu[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.campaign_id}">
                                    <label for="campaign_id">Campaign id:</label>
                                    <input type="text" class="form-control" id="campaign_id" v-model="offer.campaign_id">
                                    <small class="text-danger" v-if="errors.campaign_id">{{ errors.campaign_id[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.product_id}">
                                    <label for="product_id">Product id:</label>
                                    <input type="text" class="form-control" id="product_id" v-model="offer.product_id">
                                    <small class="text-danger" v-if="errors.product_id">{{ errors.product_id[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.shipping_discount_id}">
                                    <label for="shipping_discount_id">Shipping discount id:</label>
                                    <input type="text" class="form-control" id="shipping_discount_id" v-model="offer.shipping_discount_id">
                                    <small class="text-danger" v-if="errors.shipping_discount_id">{{ errors.shipping_discount_id[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.shipping_discount_price}">
                                    <label for="shipping_discount_price">Shipping discount price:</label>
                                    <input type="text" class="form-control" id="shipping_discount_price" v-model="offer.shipping_discount_price">
                                    <small class="text-danger" v-if="errors.shipping_discount_price">{{ errors.shipping_discount_price[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.shipping_id}">
                                    <label for="shipping_id">Shipping id:</label>
                                    <input type="text" class="form-control" id="shipping_id" v-model="offer.shipping_id">
                                    <small class="text-danger" v-if="errors.shipping_id">{{ errors.shipping_id[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.shipping_on_rebills}">
                                    <label for="shipping_on_rebills">Shipping on rebills:</label>
                                    <input type="text" class="form-control" id="shipping_on_rebills" v-model="offer.shipping_on_rebills">
                                    <small class="text-danger" v-if="errors.shipping_on_rebills">{{ errors.shipping_on_rebills[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.c_cs_accepted}">
                                    <label for="c_cs_accepted">CCs Accepted:</label>
                                    <input type="text" class="form-control" id="c_cs_accepted" v-model="offer.c_cs_accepted">
                                    <small class="text-danger" v-if="errors.c_cs_accepted">{{ errors.c_cs_accepted[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.crm}">
                                    <label for="crm">Crm:</label>
                                    <input type="text" class="form-control" id="crm" v-model="offer.crm">
                                    <small class="text-danger" v-if="errors.crm">{{ errors.crm[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.crm_password}">
                                    <label for="crm_password">Crm password:</label>
                                    <input type="text" class="form-control" id="crm_password" v-model="offer.crm_password">
                                    <small class="text-danger" v-if="errors.crm_password">{{ errors.crm_password[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.crm_site}">
                                    <label for="crm_site">Crm site:</label>
                                    <input type="text" class="form-control" id="crm_site" v-model="offer.crm_site">
                                    <small class="text-danger" v-if="errors.crm_site">{{ errors.crm_site[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.crm_username}">
                                    <label for="crm_username">Crm username:</label>
                                    <input type="text" class="form-control" id="crm_username" v-model="offer.crm_username">
                                    <small class="text-danger" v-if="errors.crm_username">{{ errors.crm_username[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"  :class="{'has-error': errors.upsell}">
                                    <label for="upsell">Upsell:</label>
                                    <input type="text" class="form-control" id="upsell" v-model="offer.upsell">
                                    <small class="text-danger" v-if="errors.upsell">{{ errors.upsell[0] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <button class="btn btn-default pull-right" @click="save()">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ofers-create',
        data() {
            return {
                offer: {},
                errors: {}
            }
        },
        methods: {
            save() {
                this.errors = {}
                axios.post('/offers', this.offer)
                .then(response => {
                    this.$router.push('/offers')
                }, error => {
                    this.errors = error.response.data.errors
                })
            }
        }
    }
</script>
