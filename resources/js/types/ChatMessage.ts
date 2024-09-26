export enum ChatMessageType {
    BOT,
    USER,
}

export type ChatMessage = {
    type: ChatMessageType;
    message: string;
};
