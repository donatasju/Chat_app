<template>
    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
        <ContactsList :contacts="contacts" @selected="startConversationWith"/>
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
                room_id: null,
                messages: [],
                contacts: []
            };
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.handleIncomingMessage(e.message);
                });

            axios.get('/contacts')
                .then((response) => {
                    this.contacts = response.data;
                });

            this.$root.$on('typing', (data) => {
                this.sendTypingState(data.typing);
                console.log(data);
            });
        },
        methods: {
            sendTypingState(isTyping) {
                if (this.room_id) {
                    console.log("Sending typing state:" + isTyping);

                    Echo.private(`rooms.${this.room_id}`)
                        .whisper('typing', {
                            typing: isTyping,
                        });
                }

            },
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);
                console.log("Conversation started with contact id: " + contact.id);

                axios.post(`/chat-room/join/${this.user.id}/${contact.id}`)
                    .then((room) => {
                        console.log(room.data.id);
                        this.joinRoom(room.data.id);
                    })

                axios.get(`/conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },
            joinRoom(room_id) {
                this.room_id = room_id;

                Echo.private(`rooms.${this.room_id}`)
                    .listenForWhisper('typing', (data) => {
                        console.log("Whisper received");
                        this.$root.$emit('respondentTyping', data);
                    });
            },
            saveNewMessage(message) {
                this.messages.push(message);
            },
            handleIncomingMessage(message) {
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

                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single;
                })
            }
        },
        components: {Conversation, ContactsList}
    }
</script>


<style lang="scss" scoped>
.chat-app {
    display: flex;
}
</style>
