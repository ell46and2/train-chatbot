<template>
    <div class="flex min-h-screen w-full items-center justify-center bg-gray-200">
        <div
            class="right-0 mr-4 h-[634px] w-[440px] overflow-y-auto rounded-lg border border-[#e5e7eb] bg-white p-6 shadow-lg">
            <!-- Heading -->
            <div class="flex flex-col space-y-1.5 pb-6">
                <h2 class="text-lg font-semibold tracking-tight">Train Chatbot</h2>
            </div>

            <!-- Chat Container -->
            <div class="h-[474px] overflow-y-auto pr-4" style="min-width: 100%; display: table">
                <Message :message="defaultMessage" />

                <Message v-for="(message, index) in messages" :key="index" :message="message" />
            </div>
            <!-- Input box  -->
            <div class="flex items-center pt-0">
                <form class="flex w-full items-center justify-center space-x-2" @submit.prevent="handleSendMessage">
                    <input
                        v-model="userInput"
                        class="flex h-10 w-full rounded-md border border-[#e5e7eb] px-3 py-2 text-sm text-[#030712] placeholder-[#6b7280] focus:outline-none focus:ring-2 focus:ring-[#9ca3af] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        placeholder="Type your message" />
                    <button
                        class="inline-flex h-10 items-center justify-center rounded-md bg-black px-4 py-2 text-sm font-medium text-[#f9fafb] hover:bg-[#111827E6] disabled:pointer-events-none disabled:opacity-50"
                        type="submit">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Message from '@/Components/ChatBot/Message.vue';
import { ChatMessage, ChatMessageType } from '@/types/ChatMessage';
import axios from 'axios';
import { ref } from 'vue';

const defaultMessage = {
    type: ChatMessageType.BOT,
    message:
        "Hi, please enter a station name to view it's next two departures or type 'stations' to view a list of all stations?",
};

const messages = ref<ChatMessage[]>([]);
const userInput = ref('');

const handleSendMessage = () => {
    if (userInput.value.trim() === '') {
        return;
    }

    messages.value.push({
        type: ChatMessageType.USER,
        message: userInput.value,
    });

    axios
        .post('/process', {
            message: userInput.value,
        })
        .then((res) => {
            messages.value.push({ type: ChatMessageType.BOT, message: res.data.bot_response as string });
        })
        .finally(() => (userInput.value = ''));
};
</script>
