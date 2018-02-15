<template>
    <div class="container m-t-20">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Offers
                        </div>
                        <div class="pull-right">
                            <router-link class="btn btn-default" to="/offers/create">
                                <i class="glyphicon glyphicon-plus"></i> Add Offer
                            </router-link>
                        </div>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Company address</th>
                                    <th>Company email</th>
                                    <th>Company phone</th>
                                    <th>Company hours</th>
                                    <th>Company name</th>
                                    <th>Product name</th>
                                    <th>Product rebill days</th>
                                    <th>Shipping price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="offer in offers">
                                    <td>{{ offer.meta_description }}</td>
                                    <td>{{ offer.company_address }}</td>
                                    <td>{{ offer.company_customer_service_email }}</td>
                                    <td>{{ offer.company_customer_service_phone }}</td>
                                    <td>{{ offer.company_hours }}</td>
                                    <td>{{ offer.company_name }}</td>
                                    <td>{{ offer.product_name }}</td>
                                    <td>{{ offer.product_rebill_days }}</td>
                                    <td>{{ offer.shipping_price }}</td>
                                    <td class="btn-group">
                                        <router-link :to="`/offers/${offer.id}/edit`" class="btn btn-xs btn-default">
                                            <i class="glyphicon glyphicon-edit"></i> Edit
                                        </router-link>
  		  			  		  		    <a class="btn btn-xs btn-default" @click="destroy(offer.id)">
                                            <i class="glyphicon glyphicon-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'offers',
        data() {
            return {
                offers: []
            }
        },
        methods: {
            getData() {
                axios.get('offers')
                .then(response => this.offers = response.data.offers)
            },
            destroy(id) {
                axios.delete(`/offers/${id}`)
                .then(response => {
                    if (response.data.success)
                        this.getData()
                })
            }
        },
        created() {
            this.getData()
        }
    }
</script>
