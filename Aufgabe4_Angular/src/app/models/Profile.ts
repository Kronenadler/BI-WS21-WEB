export class Profile {
    public firstName: string;
    public lastName: string;
    public coffeeOrTea: string;
    public description: string;
    public layout: string;

    public constructor(firstName: string, lastName: string, coffeeOrTea: string, 
            description: string, chatLayout: string) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.coffeeOrTea = coffeeOrTea;
        this.description = description;
        this.layout = chatLayout;
    }
}