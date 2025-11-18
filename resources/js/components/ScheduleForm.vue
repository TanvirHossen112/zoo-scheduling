<template>
    <div class="max-w-2xl mx-auto p-6">
        <div class="text-center mb-6">
            <a type="button" href="/visitors/daily"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Daily Visitors
            </a>
        </div>
        <h2 class="text-2xl font-bold mb-6">Schedule a visit to the Zoo!</h2>
        <div v-if="message" :class="messageClass" class="p-4 rounded-md">
            {{ message }}
        </div>
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <div>
                <label for="date" class="block text-sm font-medium mb-1">Date:</label>
                <input
                    type="date"
                    id="date"
                    v-model="form.date"
                    @change="getAvailableTimeslots"
                    @input="delete errors.date"
                    :class="['w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2', errors.date ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500']"
                />
                <p v-if="errors.date" class="text-red-600 text-sm mt-1">{{ errors.date[0] }}</p>
            </div>

            <div>
                <label for="timeslot" class="block text-sm font-medium mb-1">Timeslot:</label>
                <select
                    id="timeslot"
                    v-model="form.timeslot"
                    @change="delete errors.timeslot"
                    :class="['w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2', errors.timeslot ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500']"
                >
                    <option value="">-- Select a timeslot --</option>
                    <option v-for="(timeslot, value) in timeslots" :value="value">{{ timeslot }}</option>
                </select>
                <p v-if="errors.timeslot" class="text-red-600 text-sm mt-1">{{ errors.timeslot[0] }}</p>
            </div>

            <div v-for="(visitor, index) in form.visitors" :key="index"
                 class="p-6 border-2 border-gray-300 rounded-lg bg-white shadow-sm space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">Visitor {{ index + 1 }}</h3>
                    <button
                        v-if="form.visitors.length > 1"
                        type="button"
                        @click="removeVisitor(index)"
                        class="text-red-600 hover:text-red-800 font-medium"
                    >
                        Remove
                    </button>
                </div>
                <div>
                    <label for="first_name" class="block text-sm font-medium mb-1">First name:</label>
                    <input
                        type="text"
                        id="first_name"
                        v-model="visitor.first_name"
                        @input="delete errors[`visitors.${index}.first_name`]"
                        :class="['w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2', errors[`visitors.${index}.first_name`] ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500']"
                    />
                    <p v-if="errors[`visitors.${index}.first_name`]" class="text-red-600 text-sm mt-1">{{ errors[`visitors.${index}.first_name`][0] }}</p>
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium mb-1">Last name:</label>
                    <input
                        type="text"
                        id="last_name"
                        v-model="visitor.last_name"
                        @input="delete errors[`visitors.${index}.last_name`]"
                        :class="['w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2', errors[`visitors.${index}.last_name`] ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500']"
                    />
                    <p v-if="errors[`visitors.${index}.last_name`]" class="text-red-600 text-sm mt-1">{{ errors[`visitors.${index}.last_name`][0] }}</p>
                </div>

                <div>
                    <label for="membership_number" class="block text-sm font-medium mb-1">Membership number:</label>
                    <input
                        type="text"
                        id="membership_number"
                        v-model="visitor.membership_number"
                        @input="delete errors[`visitors.${index}.membership_number`]"
                        :class="['w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2', errors[`visitors.${index}.membership_number`] ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500']"
                    />
                    <p v-if="errors[`visitors.${index}.membership_number`]" class="text-red-600 text-sm mt-1">{{ errors[`visitors.${index}.membership_number`][0] }}</p>
                </div>
            </div>

            <div>
                <div class="mt-3 mb-2">
                    <button
                        class="w-xs bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 cursor-pointer"
                        type="button"
                        @click="addVisitor">
                        Add Visitor
                    </button>
                </div>
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-green-400 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50"
                >
                    {{ loading ? 'Submitting...' : 'Submit' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
const VISITOR_FORM = {
    first_name: '',
    last_name: '',
    membership_number: ''
};
export default {
    name: 'ScheduleForm',
    data() {
        return {
            form: {
                date: '',
                timeslot: '',
                visitors: [{...VISITOR_FORM}],
            },
            timeslots: [],
            loading: false,
            message: '',
            messageClass: '',
            errors: {}
        };
    }
    ,
    methods: {
        addVisitor() {
            if (this.form.visitors.length >= 3) {
                this.toastr('Maximum of 3 visitors allowed.', 'bg-red-100 text-red-800');
                return;
            }
            this.form.visitors.push({...VISITOR_FORM});
        },
        removeVisitor(index) {
            if (this.form.visitors.length > 1) {
                this.form.visitors.splice(index, 1);
            }
        },
        async handleSubmit() {
            this.loading = true;
            this.message = '';
            this.errors = {};

            try {
                const {data: {message}} = await axios.post('/api/v1/schedule', this.form);
                this.toastr(message, 'bg-green-100 text-green-800');
                this.form = {
                    date: '',
                    timeslot: '',
                    visitors: [{...VISITOR_FORM}],
                };
            } catch (error) {
                if (error.response?.status === 422) {
                    // Validation errors
                    this.errors = error.response.data.errors || {};
                    this.message = 'Please fix the validation errors below.';
                    this.messageClass = 'bg-red-100 text-red-800';
                } else {
                    this.message = error.response?.data?.message || 'An error occurred. Please try again.';
                    this.messageClass = 'bg-red-100 text-red-800';
                }
            } finally {
                this.loading = false;
            }
        },
        toastr: function (message, className = 'bg-green-100 text-green-800') {
            this.message = message;
            this.messageClass = className;
            setTimeout(() => {
                this.message = '';
                this.messageClass = '';
            }, 5000)
        },
        async getAvailableTimeslots() {
            try {
                const {data} = await axios.get('/api/v1/available-timeslots', {params: {date: this.form.date}});
                this.timeslots = data;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
