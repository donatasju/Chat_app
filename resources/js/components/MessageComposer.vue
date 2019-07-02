<template>
    <div class="composer">
        <textarea v-model="message" @keydown="isTyping"  @keydown.enter="send" placeholder="Message..."></textarea>
        <p v-if="show_typing_msg">Typing...</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user_timer: null,
                resp_timer: null,
                message: '',
                show_typing_msg: false
            };
        },
        mounted() {
            this.$root.$on('selected-contact', contact => {
                this.contact = contact;
            })

            this.$root.$on('respondentTyping', (data) => {
                this.onRespondentTyping(data.typing);
            })
        },
        methods: {
            send(e) {
                e.preventDefault();

                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            },
            onRespondentTyping(state) {
                console.log("Setting respondent typing state: " + state);
                this.show_typing_msg = state;
            },
            isTyping() {
                if (!this.typing_timer) {
                    this.$root.$emit('typing', {typing: true});
                } else {
                    clearTimeout(this.typing_timer);
                }

                this.typing_timer = setTimeout(function () {
                    this.$root.$emit('typing', {typing: false});
                    this.typing_timer = null;
                }.bind(this), 1500);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .composer textarea {
        width: 96%;
        margin: 10px;
        resize: none;
        border-radius: 3px;
        border: 1px solid lightgray;
        padding: 6px;
    }
</style>

