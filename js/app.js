import { getWords } from "./getWords.js";
import { QuestionComponent } from "./components/QuestionComponent.js";
import { $, element } from "./tools.js";
import { AnswerComponent } from "./components/AnswerComponent.js";
import { InitialComponent } from "./components/InitialComponent.js";
import { FinalComponent } from "./components/FinalComponent.js";

let words = [];
let wordsState = [];
let gameState = "INITIAL"; //INITIAL | QUESTION | ANSWER | FINAL

const $form = $("form");

$form.addEventListener("submit", async (event) => {
  event.preventDefault();

  if (gameState === "INITIAL") {
    gameState = "QUESTION";
    await init();
  } else if (gameState === "ANSWER" && words.length === 0) {
    gameState = "FINAL";
  } else if (gameState === "FINAL") {
    wordsState = [];
    gameState = "INITIAL";
  } else if (gameState === "QUESTION") {
    const result = await sendQuestionHandler({
      formTarget: event.target,
      wordsState,
    });
    words.shift();
    wordsState.push(result);
    gameState = "ANSWER";
  } else if (gameState === "ANSWER") {
    gameState = "QUESTION";
  }

  Navigation(gameState);
});

async function init() {
  words = await getWords();
}

function Navigation(ComponentName) {
  $form.innerHTML = "";
  if (ComponentName === "QUESTION") {
    const [$title, $p, $input, $indexContainer, $indexs] = QuestionComponent({
      $container: $form,
      wordsState,
    });
    setNewQuestion({ $p, question: words[0] });
  } else if (ComponentName === "ANSWER") {
    AnswerComponent({
      $container: $form,
      wordData: wordsState[wordsState.length - 1],
    });
  } else if (ComponentName === "FINAL") {
    FinalComponent({ $container: $form, wordsState });
  } else if (ComponentName === "INITIAL") {
    InitialComponent({ $container: $form });
  }
}

async function sendQuestionHandler({ formTarget, wordsState }) {
  const form = new FormData(formTarget);
  form.set("id", words[0].id);

  return fetch("verify-word.php", {
    method: "POST",
    credentials: "include",
    body: form,
  })
    .then((res) => res.json())
    .then((result) => {
      $form.reset();
      return result;
    });
}

function setNewQuestion({ $p, question }) {
  const questionSplitted = question.word.split("");
  const firstLetterUpperCase = questionSplitted
    .map((x, i) => (i === 0 ? x.toUpperCase() : x))
    .join("");
  $p.textContent = firstLetterUpperCase;
}
