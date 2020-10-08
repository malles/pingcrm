<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('parcs')">
                Parken
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Nieuw
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.code" :error="errors.code" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Code" />
                    <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Naam" />
                    <text-input v-model="form.address" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Adres" />
                    <text-input v-model="form.postal_code" :error="errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Postcode" />
                    <text-input v-model="form.city" :error="errors.city" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Plaats" />
                    <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2"
                                  label="Land">
                        <option :value="null">Maak een keuze</option>
                        <option value="BE">België</option>
                        <option value="DE">Duitsland</option>
                        <option value="NL">Nederland</option>
                        <option value="UK">Verenigd Koninkrijk</option>
                    </select-input>
                    <text-input v-model="form.contact" :error="errors.contact" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Contactpersoon" />
                    <text-input v-model="form.email" :error="errors.email" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="E-mail" />
                    <text-input v-model="form.phone" :error="errors.phone" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Telefoon" />
                    <textarea-input v-model="form.notes" :error="errors.notes" class="pr-6 pb-8 w-full"
                                    label="Notities" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">
                        Maak park aan
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import SelectInput from '@/Shared/SelectInput';
import TextInput from '@/Shared/TextInput';
import TextareaInput from '@/Shared/TextareaInput';

export default {
    metaInfo: {title: 'Maak nieuw Park',},
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        TextareaInput,
    },
    props: {
        errors: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                code: null,
                name: null,
                address: null,
                postal_code: null,
                city: null,
                country: null,
                contact: null,
                email: null,
                phone: null,
                notes: null,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('parcs.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
    },
};
</script>
