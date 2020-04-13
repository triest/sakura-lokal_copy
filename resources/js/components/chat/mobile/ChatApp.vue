<template>
    <div class="chat-app"> <!-- lg комп-->
        <button class="btn btn-primary" @click="showContactListFunction()">Показать анкеты</button>
        <div class="col-lg-9  ">
            <contacts-list :contacts="contacts" @selected="startConversationWith"
                           v-if="showContactListCheck()"></contacts-list>
        </div>
        <div class="col-lg-9">
            <Conversation :contact="selectedContact" v-if="!showContactListCheck()" :messages="messages"
                          @new="saveNewMessage"/>
        </div>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                unreaded: 0,
                showContartListVarible: false,
            };
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                });

            axios.get('/contacts')
                .then((response) => {
                    this.contacts = response.data;
                });
        },
        methods: {
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);

                axios.get(`/conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
                this.showContartListVarible = false
            },
            showContactListFunction() {
                this.showContartListVarible = !this.showContartListVarible;
            },
            showContactList() {

            },
            saveNewMessage(message) {
                this.messages.push(message);
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }

                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }

                    if (reset) {
                        single.unread = 0;
                    }
                    else {
                        single.unread += 1;
                        this.unreaded += 1;
                    }
                    return single;
                })
            },
            showContactListCheck() {
                //     this.showContartListVarible=false
                return this.showContartListVarible;
            }
        },
        components: {Conversation, ContactsList}
    }
</script>

<!--
<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
-->