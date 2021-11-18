export class Message {
    public msg: string;
    public from: string;
    public time: number;

    public constructor(msg: string, from: string, time: number) {
        this.msg = msg;
        this.from = from;
        this.time = time;
    }
}