package com.example.killmeplease;

public class TopicItem {
    public final String title;
    public final String content;
    public final String taskText;
    public final String starterCode;
    public final String expectedOutput;
    public final String[] requiredSnippets;
    public final String videoUrl;
    public final int[] exampleImageRes;

    public TopicItem(
            String title,
            String content,
            String taskText,
            String starterCode,
            String expectedOutput,
            String[] requiredSnippets,
            String videoUrl,
            int[] exampleImageRes
    ) {
        this.title = title;
        this.content = content;
        this.taskText = taskText;
        this.starterCode = starterCode;
        this.expectedOutput = expectedOutput;
        this.requiredSnippets = requiredSnippets;
        this.videoUrl = videoUrl;
        this.exampleImageRes = exampleImageRes;
    }
}
