export class Friend {
    public username: string;
    public status: string;
    public unreadMessages: number;

    public constructor(username: string, status: string, unreadMessages: number) {
        this.username = username;
        this.status = status;
        this.unreadMessages = unreadMessages;
    }
}