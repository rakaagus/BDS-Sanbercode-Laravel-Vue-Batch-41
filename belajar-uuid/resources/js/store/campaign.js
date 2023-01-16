import axios from 'axios'
import { defineStore } from 'pinia'

export const useCampaignStore = defineStore('campaign', {
    // arrow function recommended for full type inference
    state: () => {
      return {
        // all these properties will have their type inferred automatically
        dataCampaign: null,
      }
    },
    actions: {
        async getData(){
            try {
                const getData = await axios.get("/api/campaign");
                const data = getData.data.data.campaign;
                this.dataCampaign.push(data);
              } catch (error) {
                console.log(error);
              }
        },
    },
    persist: true
})
