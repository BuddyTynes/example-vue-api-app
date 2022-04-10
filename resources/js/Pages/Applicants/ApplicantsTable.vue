<script setup>
import useApplicants from '../../Composables/Applicants.js';
import useSkills from '../../Composables/Skills.js';
import { onMounted, reactive } from 'vue';

const { applicants, links, getApplicants, addApplicant, deleteApplicant, searchApplicant } = useApplicants();
const { skills, getSkills, deleteSkill } = useSkills();

const form = reactive({
    'first_name': '',
    'last_name': '',
    'skills': [],
});

const search = reactive({
    'query': '',
});

onMounted(() => {
    getApplicants();
    getSkills();
});

const destroyApplicant = async (id) => {
    if (!window.confirm('Are you sure you want to delete this applicant?')) {
        return;
    }
    await deleteApplicant(id);
    await getApplicants();
};

const saveApplicant = async () => {
    await addApplicant({...form});
    await getApplicants();
    form.first_name = '';
    form.last_name = '';
    form.skills = [];
    toggleModal('create-applicant-modal');
};

const toggleModal = (id) => { 
    var modal = document.getElementById(id);
	modal.classList.toggle('hidden');
}

const findPage = async (page) => {
    console.log(page);
    await getApplicants(page);
};

const searchApplicants = async () => {
    console.log('searching');
    await searchApplicant(search.query);
};
</script>

<template>
    <div>
        <!-- create a table to search applicants -->
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <!-- Modal toggle -->
                    <button @click="toggleModal('create-applicant-modal')" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Add Applicant
                    </button>
                    <!-- create applicant modal -->
                    <div id="create-applicant-modal" tabindex="-1" aria-hidden="true" class="hidden flex justify-center items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- close modal -->
                                <div class="flex justify-end p-2">
                                    <button @click="toggleModal('create-applicant-modal')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                    </button>
                                </div>
                                <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" @submit.prevent="saveApplicant">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Add a new Applicant to the system.</h3>
                                    <!-- input for first_name -->
                                    <div class="flex flex-col">
                                        <label for="first_name" class="block text-gray-700 dark:text-gray-400 text-sm font-medium mb-2">
                                            First Name
                                        </label>
                                        <input  id="first_name" type="text" placeholder="First Name" v-model="form.first_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                                    </div>
                                    <!-- input for last_name -->
                                    <div class="flex flex-col">
                                        <label for="last_name" class="block text-gray-700 dark:text-gray-400 text-sm font-medium mb-2">
                                            Last Name
                                        </label>
                                        <input  id="last_name" type="text" placeholder="Last Name" v-model="form.last_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    </div>
                                    <!-- Skill checkboxes -->
                                    <div class="flex flex-col">
                                        <label for="skills" class="block text-gray-700 dark:text-gray-400 text-sm font-medium mb-2">
                                            Skills
                                        </label>
                                        <div class="flex flex-wrap">
                                            <div class="grid grid-cols-5 gap-8">
                                                <div v-for="skill in skills" :key="skill.id" class="flex flex-col">
                                                    <div class="flex flex-col">
                                                        <input id="{{skill.id}}" type="checkbox" v-model="form.skills" :value="skill.id" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                        <label for="{{skill.id}}" class="block text-gray-700 dark:text-gray-400 text-sm font-medium mb-2">
                                                            {{skill.name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                    <!-- save or cancel-->
                                    <div class="flex justify-end">
                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Save
                                        </button>
                                        <button type="button" @click="toggleModal('create-applicant-modal')" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                    <!-- end applicant modal -->
                    <!-- Applicants table -->
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <button @click="findPage(links.prev)" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button @click="findPage(links.next)" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <input type="text" v-model="search.query" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Search">
                            <button @click="searchApplicants" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Search
                            </button>
                        </div>
                    </div>
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Skills
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr v-for="applicant in applicants" :key="applicant.id">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900">{{ applicant.first_name }}</div>
                                            <div class="text-sm leading-5 text-gray-500">{{ applicant.last_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <span>{{ applicant.status }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900">
                                        <span v-for="skills in applicant.skills" :key="skills.id" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <span>{{ skills.skill.name }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <button class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" @click="destroyApplicant(applicant.id)">
                                                Delete
                                            </button>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</template>
