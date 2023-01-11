export const UsersComponent = {
    template: `
    <div class="usersList">
        <ul>
            <li v-for="(user , index) in reverseUsers" :key="index">
                {{ user.name }} ||
                <button @click="$emit('edit', index)">Edit</button>
                <button @click="$emit('delete', index)">Delete</button>
            </li>
        </ul>
    </div>
    `,
    props: ['reverseUsers']
}