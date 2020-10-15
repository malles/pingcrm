<template>
    <div class="pr-6 pb-8 grid grid-cols-4 gap-4 w-full">
        <div v-if="showCarriage" class="col-span-3 flex items-center justify-end">Vrachtkosten:</div>
        <div v-if="showCarriage">
            {{ order.carriage_price | currency }}
        </div>
        <div class="flex justify-end">Inkoopprijs:</div>
        <div class="">
            {{ order.cost_price | currency }}
        </div>
        <div class="flex justify-end">Verkoopprijs:</div>
        <div class="flex justify-end">
            {{ order.selling_price | currency }}
        </div>
        <div class="col-span-3 flex justify-end">BTW:</div>
        <div class="flex justify-end">
            {{ order.vat | currency }}
        </div>
        <div class="flex justify-end pt-2">Marge:</div>
        <div class="pt-2">
            <span>{{ marginAmount | currency }} <small class="ml-2">({{ marginPercentage }}%)</small></span>
        </div>
        <div class="flex justify-end pt-2">Totaal:</div>
        <div class="border-t font-bold flex justify-end text-lg pt-2">
            {{ invoiceTotal | currency }}
        </div>
    </div>
</template>
<script>

export default {

    name: 'OrderTotals',

    props: {
        order: Object,
        showCarriage: {type: Boolean, default: false,},
    },

    computed: {
        marginAmount() {
            return this.order.selling_price - this.order.cost_price;
        },
        marginPercentage() {
            return Math.round((this.marginAmount / (this.order.cost_price || 1)) * 100);
        },
        invoiceTotal() {
            return this.order.selling_price + this.order.vat;
        },
    },
};
</script>
