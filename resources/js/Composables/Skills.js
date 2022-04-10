import { ref } from 'vue';
import axios from 'axios';

export default function useSkills() {
    const skills = ref([]);
    
    const getSkills = async () => {
        const response = await axios.get('/api/skills');

        skills.value = response.data.data;
    };

    const addSkill = async (skill) => {
        const response = await axios.post('/api/skills', skill);
        skills.value.push(response.data);
    };
    
    const updateSkill = async (skill) => {
        const response = await axios.put(`/api/skills/${skill.id}`, skill);
        const index = skills.value.findIndex((a) => a.id === skill.id);
        skills.value[index] = response.data;
    };
    
    const deleteSkill = async (id) => {
        await axios.delete(`/api/skills/${id}`);
    };
    
    return {
        skills,
        getSkills,
        deleteSkill,
    };
}