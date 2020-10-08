<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('parcs')">
                Parken
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="parc.deleted_at" class="mb-6" @restore="restore">
            Dit park is verwijderd.
        </trashed-message>
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
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!parc.deleted_at" class="text-red-600 hover:underline" tabindex="-1"
                            type="button" @click="destroy">
                        Verwijder park
                    </button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">
                        Sla park op
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
import TrashedMessage from '@/Shared/TrashedMessage';

export default {
    metaInfo() {
        return {title: this.form.name,};
    },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        TrashedMessage,
    },
    props: {
        errors: Object,
        parc: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                code: this.parc.code,
                name: this.parc.name,
                address: this.parc.address,
                city: this.parc.city,
                postal_code: this.parc.postal_code,
                country: this.parc.country,
                contact: this.parc.contact,
                email: this.parc.email,
                phone: this.parc.phone,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.put(this.route('parcs.update', this.parc.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
        destroy() {
            if (confirm('Wil je dit park verwijderen?')) {
                this.$inertia.delete(this.route('parcs.destroy', this.parc.id));
            }
        },
        restore() {
            if (confirm('Wil je dit park herstellen?')) {
                this.$inertia.put(this.route('parcs.restore', this.parc.id));
            }
        },
    },
};
</script>
