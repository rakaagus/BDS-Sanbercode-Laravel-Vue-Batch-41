import axios from 'axios'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
    // arrow function recommended for full type inference
    state: () => {
      return {
        // all these properties will have their type inferred automatically
        token: "",
        user: null,
        isLogin: false,
        isAdmin: false,
      }
    },
    actions: {
        async setToken(token){
            this.token = token

            const config = {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }

            try {
                const userData = await axios.get("/api/get-profile", config);

                const userRole = userData.data.data.user
                this.user = userRole
                if(userRole.role.name == "user"){
                    this.isAdmin = false
                }else if(userRole.role.name == "admin"){
                    this.isAdmin = true
                } else{
                    this.isAdmin = null
                }

                this.isLogin = true
            } catch (error) {
                console.log(error)
            }
        },
        async removeAuth(){
            this.token =  "";
            this.user =  null;
            this.isLogin =  false;
            this.isAdmin = false;
        }
    },
    persist: true
  })
