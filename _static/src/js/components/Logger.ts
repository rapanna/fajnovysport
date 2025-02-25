/* eslint-disable no-console */
class Logger {
	public error(message: string, error: Error | null = null): void {
		console.error(
			"%c LOG ERROR: ",
			"color: red",
			message,
			error,
			JSON.stringify(error),
		);
	}

	public log(message: unknown, data?: unknown): void {
		const date = new Date();
		console.log(
			`%c LOG: ${date.toLocaleTimeString()}%c ${message as string}`,
			"color: blue",
			"color: #666",
			data !== undefined ? data : "",
		);
	}
}

export default new Logger();
